<?php
//载入ucpass类
require_once('lib/Ucpaas.class.php');

//初始化必填
//填写在开发者控制台首页上的Account Sid
$options['accountsid']='46f7f9e42752e6a89a5e11799b1f90fb';
//填写在开发者控制台首页上的Auth Token
$options['token']='0e7bca95cbd8147117777046d6d4adfd';

//初始化 $options必填
$ucpass = new Ucpaas($options);