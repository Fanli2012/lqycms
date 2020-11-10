<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Common\ReturnData;
use Illuminate\Http\Request;
use App\Common\Helper;
use App\Common\Utils\Database as DatabaseUtil;

class DatabaseController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
		$data['list'] = $this->get_all_table();
		return view('admin.database.index', $data);
    }

    public function get_all_table()
    {
        $list = DB::select('SHOW TABLE STATUS');
		$list = object_to_array($list);
        $list = array_map('array_change_key_case', $list);
        return $list;
    }

    public function recovery()
    {
        $path = base_path() . DIRECTORY_SEPARATOR . 'database_backup';
        //判断目录是否存在
        is_writeable($path) || mkdir('./' . C("DB_PATH_NAME") . '', 0777, true);
        //列出备份文件列表
        $flag = \FilesystemIterator::KEY_AS_FILENAME;
        $glob = new \FilesystemIterator($path, $flag);

        $list = array();
        foreach ($glob as $name => $file) {
            if (preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)) {
                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[6];

                if (isset($list["{$date} {$time}"])) {
                    $info = $list["{$date} {$time}"];
                    $info['part'] = max($info['part'], $part);
                    $info['size'] = $info['size'] + $file->getSize();
                } else {
                    $info['part'] = $part;
                    $info['size'] = $file->getSize();
                }
                $extension = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                $info['time'] = strtotime("{$date} {$time}");

                $list["{$date} {$time}"] = $info;
            }
        }
        $this->assign('list', $list);
        $this->display();
    }

    /**
     * 优化表
     * @param String $tables 表名
     */
    public function optimize($tables = null)
    {
		if (!$tables) {
			$tables = request('tables');
		}
        if (!$tables) {
            error_jump("请指定要优化的表");
        }
        if (is_array($tables)) {
            if (count($tables) > 5) {
                $all_table = $this->get_all_table();
                foreach ($all_table as $k => $v) {
                    DB::statement("OPTIMIZE TABLE `" . $v['name'] . "`");
                }
                success_jump("数据库优化完成");
            }
            $tables = implode('`,`', $tables);
            $list = DB::statement("OPTIMIZE TABLE `{$tables}`");
            if (!$list) {
                error_jump("数据表优化出错请重试");
            }
            success_jump("数据表优化完成");
        }
        if (substr_count($tables, ',') > 5) {
            $all_table = $this->get_all_table();
            foreach ($all_table as $k => $v) {
                DB::statement("OPTIMIZE TABLE `" . $v['name'] . "`");
            }
            success_jump("数据库优化完成");
        }
        $list = DB::statement("OPTIMIZE TABLE `{$tables}`");
        if (!$list) {
            error_jump("数据表'{$tables}'优化出错请重试");
        }
        success_jump("数据表'{$tables}'优化完成");
    }

    /**
     * 修复表
     * @param String $tables 表名
     */
    public function repair($tables = null)
    {
		if (!$tables) {
			$tables = request('tables');
		}
        if (!$tables) {
            error_jump("请指定要修复的表");
        }
        if (is_array($tables)) {
            if (count($tables) > 5) {
                $all_table = $this->get_all_table();
                foreach ($all_table as $k => $v) {
                    DB::statement("REPAIR TABLE `" . $v['name'] . "`");
                }
                success_jump("数据库修复完成");
            }
            $tables = implode('`,`', $tables);
            $list = DB::statement("REPAIR TABLE `{$tables}`");
            if (!$list) {
                error_jump("数据表修复出错请重试");
            }
            success_jump("数据表修复完成");
        }
        if (substr_count($tables, ',') > 5) {
            $all_table = $this->get_all_table();
            foreach ($all_table as $k => $v) {
                DB::statement("REPAIR TABLE `" . $v['name'] . "`");
            }
            success_jump("数据库修复完成");
        }
        $list = DB::statement("REPAIR TABLE `{$tables}`");
        if (!$list) {
            error_jump("数据表'{$tables}'修复出错请重试");
        }
        success_jump("数据表'{$tables}'修复完成");
    }

    /**
     * 删除备份文件
     * @param Integer $time 备份时间
     */
    public function del($time = 0)
    {
        if (!$time) {
            error_jump('参数错误');
        }
        $name = date('Ymd-His', $time) . '-*.sql*';
        $path = base_path() . DIRECTORY_SEPARATOR . 'database_backup' . DIRECTORY_SEPARATOR . $name;
        array_map("unlink", glob($path));
        if (count(glob($path))) {
            error_jump('备份文件删除失败，请检查权限');
        }
        success_jump('备份文件删除成功');
    }

    /**
     * 备份数据库
     * @param String $tables 表名
     * @param Integer $id 表ID
     * @param Integer $start 起始行数
     */
    public function tables_backup()
    {
        $tables = request('tables');
        if (!$tables) {
            error_jump('参数错误');
        }
        $tables = explode(',', $tables);
        //初始化
        if (!(!empty($tables) && is_array($tables))) {
            error_jump('参数错误');
        }
        if (count($tables) > 5) {
            $all_table = $this->get_all_table();
            $tables = array_column($all_table, 'name');
        }

        $backup_path = base_path() . DIRECTORY_SEPARATOR . 'database_backup' . DIRECTORY_SEPARATOR;
        foreach ($tables as $table) {
            $filename = "{$backup_path}{$table}.sql";
            //判断文件是否已经存在
            if (file_exists($filename)) {
                unlink($filename);
            }
            $fp = @fopen($filename, 'a');
            //将每个表的表结构导出到文件
            $table_structure = DB::select("SHOW CREATE TABLE `{$table}`");
			$table_structure = object_to_array($table_structure);
            $sql = "\n";
            $sql .= "-- -----------------------------\n";
            $sql .= "-- Table structure for `{$table}`\n";
            $sql .= "-- -----------------------------\n";
			$sql .= "\n";
            $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
			$sql .= "\n";
            //$sql .= trim($table_structure[0]['create table']) . ";\n";
            $sql .= trim($table_structure[0]['Create Table']) . ";\n";
			$sql .= "\n";

            //将每个表的数据导出到文件
            $table_data = DB::select("select * from " . $table);
            if ($table_data) {
				$table_data = object_to_array($table_data);
				//数据量5万条以下导出
				if (count($table_data) < 50000) {
					$sqlStr = "INSERT INTO `" . $table . "` VALUES (";
					foreach ($table_data as $k => $v) {
						$keys = array_keys($v);
						foreach ($keys as $row) {
							$sqlStr .= "'" . $v[$row] . "', ";
						}
						//去掉最后一个逗号和空格
						$sqlStr = substr($sqlStr, 0, strlen($sqlStr) - 2);
						$sqlStr = $sqlStr . '), (';
					}
					//去掉最后一个逗号和空格
					$sqlStr = substr($sqlStr, 0, strlen($sqlStr) - 3);
					$sqlStr .= ";\n";
					$sql .= $sqlStr;
				}
            }

            if (false === @fwrite($fp, $sql)) {
                error_jump($table . '备份失败');
            }
        }
        success_jump('备份完成');
    }

    /**
     * 备份数据库
     * @param  String $tables 表名
     * @param  Integer $id 表ID
     * @param  Integer $start 起始行数
     */
    public function backup()
    {
        if (Helper::isPostRequest()) {
            $tables = request('tables');
            if (!$tables) {
                error_jump('参数错误');
            }
            $tables = explode(',', $tables);
            //初始化
            if (!(!empty($tables) && is_array($tables))) {
                error_jump('参数错误');
            }
            //读取备份配置
            $config = array(
                'path' => base_path() . DIRECTORY_SEPARATOR . 'database_backup' . DIRECTORY_SEPARATOR,  //路径
                'part' => 20971520, // 该值用于限制压缩后的分卷最大长度。单位：B；建议设置20M
                'compress' => 1, // 压缩备份文件需要PHP环境支持gzopen,gzwrite函数 0:不压缩 1:启用压缩
                'level' => 9, // 压缩级别, 1:普通 4:一般  9:最高
            );
            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup_database.lock";
            if (is_file($lock)) {
                error_jump('检测到有一个备份任务正在执行，请稍后再试');
            }
            //创建锁文件
            file_put_contents($lock, time());

            //检查备份目录是否可写 创建备份目录
            is_writeable($config['path']) || mkdir($config['path'], 0777, true);
            session('backup_config', $config);

            //生成备份文件信息
            $file = array(
                'name' => date('Ymd-His'),
                'part' => 1,
            );
            session('backup_file', $file);

            //缓存要备份的表
            session('backup_tables', $tables);

            //创建备份文件
            $database = new DatabaseUtil($file, $config);
            if (false !== $database->create()) {
                $tab = array('id' => 0, 'start' => 0);
                success_jump('初始化成功', '', array('tables' => $tables, 'tab' => $tab));
            }
            error_jump('初始化失败，备份文件创建失败');
        }
        $id = request('id');
        $start = request('start');
        //备份数据
        if (is_numeric($id) && is_numeric($start)) {
            error_jump('参数错误');
        }
        $tables = session('backup_tables');
        //备份指定表
        $database = new DatabaseUtil(session('backup_file'), session('backup_config'));
        $start = $database->backup($tables[$id], $start);
        if (false === $start) { //出错
            error_jump('备份出错');
        } elseif (0 === $start) { //下一表
            if (isset($tables[++$id])) {
                $tab = array('id' => $id, 'start' => 0);
                success_jump('备份完成', '', array('tab' => $tab));
            } else { //备份完成，清空缓存
                unlink(session('backup_config.path') . 'backup_database.lock');
                session('backup_tables', null);
                session('backup_file', null);
                session('backup_config', null);
                success_jump('备份完成');
            }
        } else {
            $tab = array('id' => $id, 'start' => $start[0]);
            $rate = floor(100 * ($start[0] / $start[1]));
            success_jump("正在备份...({$rate}%)", '', array('tab' => $tab));
        }
    }

    /**
     * 还原数据库
     */
    public function import($time = 0, $part = null, $start = null)
    {
        if (is_numeric($time) && is_null($part) && is_null($start)) { //初始化
            //获取备份文件信息
            $name = date('Ymd-His', $time) . '-*.sql*';
            $path = realpath(C('DB_PATH')) . DIRECTORY_SEPARATOR . $name;
            $files = glob($path);
            $list = array();
            foreach ($files as $name) {
                $basename = basename($name);
                $match = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
                $gz = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
                $list[$match[6]] = array($match[6], $name, $gz);
            }
            ksort($list);

            //检测文件正确性
            $last = end($list);
            if (count($list) === $last[0]) {
                session('backup_list', $list); //缓存备份列表
                success_jump('初始化完成', '', array('part' => 1, 'start' => 0));
            } else {
                error_jump('备份文件可能已经损坏，请检查');
            }
        } elseif (is_numeric($part) && is_numeric($start)) {
            $list = session('backup_list');
            $db = new DatabaseUtil($list[$part], array(
                'path' => realpath(C('DB_PATH')) . DIRECTORY_SEPARATOR,
                'compress' => $list[$part][2]
            ));

            $start = $db->import($start);

            if (false === $start) {
                error_jump('还原数据出错');
            } elseif (0 === $start) { //下一卷
                if (isset($list[++$part])) {
                    $data = array('part' => $part, 'start' => 0);
                    success_jump("正在还原...#{$part}", '', $data);
                } else {
                    session('backup_list', null);
                    success_jump('还原完成');
                }
            } else {
                $data = array('part' => $part, 'start' => $start[0]);
                if ($start[1]) {
                    $rate = floor(100 * ($start[0] / $start[1]));
                    success_jump("正在还原...#{$part} ({$rate}%)", '', $data);
                } else {
                    $data['gz'] = 1;
                    success_jump("正在还原...#{$part}", '', $data);
                }
            }
        } else {
            error_jump('参数错误');
        }
    }
}