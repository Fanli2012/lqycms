
git clone https://github.com/Fanli2012/lqycms.git

cmd�´���.env�ļ�
echo hello > .env


˵��

1������Laravel 5.4
2��PHP+Mysql
3����̨��¼��/fladmin/login
�˺ţ�admin888
���룺admin
4���ָ���̨Ĭ���˺����룺/fladmin/recoverpwd


��װ

1�� �������ݿ�
1) �򿪸�Ŀ¼�µ�lqycms.sql�ļ����� http://www.lqycms.com �ĳ��Լ���վ�����ַ����ʽ��http://+����
2) �������ݿ�

2������.env.example��������.env���޸���Ӧ����APP_DOMAIN��APP_SUBDOMAIN�����ݿ�����

3��
php composer.phar install
php artisan key:generate

4�� ��¼��̨->������ť�����»��棺/fladmin/login.php���˺ţ�admin888�����룺123456


ע��

ֻ�ܷ��ڸ�Ŀ¼
���Ҫ��������ģʽ�����޸� .env �ļ��� APP_ENV=local �� APP_DEBUG=true ��



Simple QrCode�ĵ���https://www.simplesoftware.io/docs/simple-qrcode/zh
$qrcode = new \SimpleSoftwareIO\QrCode\BaconQrCodeGenerator;
return $qrcode->size(500)->generate('Make a qrcode without Laravel!');

����������ֱ����ʾ�ɶ�ά��ͼƬreturn '<img src="data:image/png;base64,'.base64_encode(\QrCode::format('png')->encoding('UTF-8')->size(200)->generate('http://www.baidu.com/')).'">';


composer.phar install��װ����proc_open���󣬽���취
�޸�composer.json��scripts�µ�"php artisan optimize"Ϊ"php artisan clear-compiled"


composer�й�ȫ�������޸�
������Ŀ�ĸ�Ŀ¼��Ҳ���� composer.json �ļ�����Ŀ¼����ִ���������
composer config repo.packagist composer https://packagist.phpcomposer.com


΢�ſ�����֧��
https://easywechat.org/











