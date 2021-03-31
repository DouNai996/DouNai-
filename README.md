# 前言

类似于[sever酱](http://sc.ftqq.com/)，自行搭建无次数内容限制

核心代码就一句 [这里有介绍](https://mabbs.github.io/2021/02/02/serverchan.html) 在这个基础上进行了完善

## 准备工作


 - PHP
 - Mysql
 - 有✋


## 部署

 1. 下载源代码，上传至~~服务器~~
 2. 修改Config
 
 
   {
    "appID": "@@@@@@@@@@@@@@@@",   **[微信公众平台](https://mp.weixin.qq.com/debug/cgi-bin/sandboxinfo?action=showinfo&t=sandbox/index)#### 测试号信息**
    
    "appsecret": "@@@@@@@@@@@@@@",**[微信公众平台](https://mp.weixin.qq.com/debug/cgi-bin/sandboxinfo?action=showinfo&t=sandbox/index)#### 测试号信息**
    
    "userid": "@@@@@@@@@@@@@@@@", **#### 扫描关注测试号用户列表微信号**
    
    "template_id": "@@@@@@@@@@@@@@@@@@",**#### 模板消息接口模板ID(第一次使用要新建模板 模板与[sever酱](http://sc.ftqq.com/)通用 模板填入  {{title.DATA}}{{content.DATA}}  标题随意**
    
    "access_token": "", **#### 不填他**
    
    "servername": "localhost",**#### 你的Mysql地址**
    
    "username": "豆奶酱",**#### 你的Mysql账号**
    
    "password": "BKNtCEELbZLxr26A",**#### 你的Mysql密码**
    
    "dbname": "豆奶酱",**#### 你的Mysql库名**
    
    "web": "http://www.baidu.com/"**#### 你的域名或者IP（最后要带/）**
    }

    3.**Mysql数据库操作**
   
    登入phpmyadmin后导入 data.sql 文件

	

## API接口

Http://{HOST}/api.php?title={标题}&content={内容}

## 后续可能更新

~~更多的微信展示效果~~
~~多账号支持~~
~~群组支持~~
~~多渠道支持~~
