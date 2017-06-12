<script type="text/javascript">
$(document).ready(function(){
	$('.inactive').click(function(){
		var className=$(this).parents('li').parents().attr('class');
		
		if($(this).siblings('ul').css('display')=='none')
		{
			if(className=="leftmenu")
			{
				$(this).parents('li').siblings('li').children('ul').parent('li').children('a').removeClass('active');
				$(this).parents('li').siblings('li').children('ul').slideUp(100);
				$(this).parents('li').children('ul').children('li').children('ul').parent('li').children('a').removeClass('active');
				$(this).parents('li').children('ul').children('li').children('ul').slideUp(100);
			}
			
			$(this).addClass('active');
			$(this).siblings('ul').slideDown(100);
		}
		else
		{
			$(this).removeClass('active');
			$(this).siblings('ul').slideUp(100);
		}
	});
	
	$('.active').trigger("click");
});
</script>
<div class="menu">
<ul class="leftmenu">
<?php if($menus){ foreach($menus as $k=>$first){ ?>
<!-- 一级菜单 -->
<li><a href="<?php if(isset($first['child'])){echo 'javascript:;';}else{echo route($first['action']);} ?>" class="<?php if(isset($first['child'])){echo 'inactive ';} if($k==0){echo 'active ';} ?>"><?php if($first['icon']){echo '<small class="'.$first['icon'].'"></small>';} ?> <?php echo $first['name']; ?></a>
	<!-- 二级菜单 -->
	<?php if(isset($first['child'])){ ?>
	<ul style="display: none">
	<?php foreach($first['child'] as $second){ ?>
		<li><a target="appiframe" href="<?php if(isset($second['child'])){echo 'javascript:;';}else{echo route($second['action']);} ?>" class="<?php if(isset($second['child'])){echo 'inactive ';} ?>"><small class="glyphicon glyphicon-triangle-right"></small> <?php echo $second['name']; ?></a>
			<!-- 三级菜单 -->
			<?php if(isset($second['child'])){ ?>
			<ul><?php foreach($second['child'] as $third){ ?>
				<li><a target="appiframe" href="{{ route($third['action']) }}"><small class="glyphicon glyphicon-menu-right"></small> <?php echo $third['name']; ?></a></li><?php } ?>
			</ul><?php } ?>
		</li>
	<?php } ?>
	</ul><?php } ?>
</li>
<?php }} ?>
</ul>
</div>