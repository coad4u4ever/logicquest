<style type="text/css">
	.div-header{
		background-color: black;
		height: 70px;
		line-height: 70px;
		padding-left: 60px;
   		width: 100%;
	}
	.font-logo{
		font-weight: bold;
		font-size: 40px;
		color: white;
		line-height: normal;
		vertical-align: middle;
	}

	.center-top-mid{
		position: absolute;
		top: 0;
		right: 47%;
		border: 0;
	}

	.button-facebook{
		width:20%;
		white-space: nowrap;		
	}

    .span-right{
    	float:right;
    	background-color: #466299;
 		height: 70px;
		line-height: 70px;
		display: inline-block;
		font-size: 24px;
		color: #FFFFFF;
		padding-left: 20px;
		padding-right: 10px;

    }

    .a-header{
    	color: white;
    }
</style>
<!-- <a href="<?= base_url('MainController/main')?>">
	<img class="center-top-mid"
	src="<?=base_url('assets/logicquest/img/ranking_logo_2.png')?>"
	alt="World Ranking">
</a> -->

<div class="div-header">
	<?php if($this->session->userdata('user_id') != NULL) :?>
	<a href="<?=base_url('MainController/main')?>">
	<?php else :?>
	<a href="<?=base_url('')?>">
	<?php endif; ?>	
	<span class="font-logo">LOGIC QUEST</span>
	</a>
	<?php if ($this->session->userdata('user_id') != NULL) : ?>
        <span class="span-right">
        	<a class="a-header"  href="<?= base_url('MainController/main')?>">
        	<?php if ($this->session->userdata('user_rank') != NULL) : ?>
        	<font style="color:#F0D349; vertical-align: center;">Rank <?= $this->session->userdata('user_rank') ?></font>
        	<?php endif; ?>
        	&nbsp;&nbsp;
    		<img src="//graph.facebook.com/<?=$this->session->userdata('user_id');?>/picture">
			&nbsp;&nbsp;
            <?=$this->session->userdata('user_name');?>
            &nbsp;&nbsp;&nbsp;&nbsp;
            </a>
            <a class="a-header" href="<?=base_url('MainController/facebook_logout')?>">
            	<span class="fui-exit"></span>
            </a>
        </span>
	<?php endif; ?>
</div>
