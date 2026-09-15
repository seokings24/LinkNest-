<?php
function db():PDO{static $p;if($p)return $p;$p=new PDO('sqlite:'.__DIR__.'/data/links.sqlite');$p->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);$p->exec('CREATE TABLE IF NOT EXISTS links(id INTEGER PRIMARY KEY AUTOINCREMENT,slug TEXT UNIQUE NOT NULL,title TEXT NOT NULL,image TEXT NOT NULL,destination TEXT NOT NULL,owner_id TEXT NOT NULL,created_at TEXT DEFAULT CURRENT_TIMESTAMP)');return $p;}
function owner_id():string{$n='ln_browser_id';if(empty($_COOKIE[$n])){$id=bin2hex(random_bytes(24));setcookie($n,$id,['expires'=>time()+157680000,'path'=>'/','secure'=>!empty($_SERVER['HTTPS']),'httponly'=>true,'samesite'=>'Lax']);return $id;}return $_COOKIE[$n];}
function get_links():array{$q=db()->prepare('SELECT slug,title,image,destination,created_at FROM links WHERE owner_id=? ORDER BY id DESC');$q->execute([owner_id()]);return $q->fetchAll(PDO::FETCH_ASSOC);}
function json(array $x,int $s=200):never{http_response_code($s);echo json_encode($x,JSON_UNESCAPED_SLASHES);exit;}
