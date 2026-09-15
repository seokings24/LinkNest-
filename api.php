<?php
require __DIR__.'/lib.php'; header('Content-Type: application/json');
try{$a=$_GET['action']??'list';
if($a==='list'){json(['links'=>get_links()]);}
if($a==='create'){$b=json_decode(file_get_contents('php://input'),true)?:[];$slug=trim((string)($b['slug']??''));$title=trim((string)($b['title']??''));$image=trim((string)($b['image']??''));$dest=trim((string)($b['destination']??''));
if(!preg_match('/^[A-Za-z0-9_-]+$/',$slug))json(['error'=>'URL slug may contain only letters, numbers, - and _.'],400);
if(!$title||!filter_var($image,FILTER_VALIDATE_URL)||!filter_var($dest,FILTER_VALIDATE_URL))json(['error'=>'Title, photo URL and destination URL are required.'],400);
try{$q=db()->prepare('INSERT INTO links(slug,title,image,destination,owner_id) VALUES(?,?,?,?,?)');$q->execute([$slug,$title,$image,$dest,owner_id()]);}catch(PDOException $e){if(str_contains(strtolower($e->getMessage()),'unique'))json(['error'=>'That URL slug already exists.'],409);throw $e;}json(['ok'=>true]);}
if($a==='delete'){$b=json_decode(file_get_contents('php://input'),true)?:[];$q=db()->prepare('DELETE FROM links WHERE slug=? AND owner_id=?');$q->execute([(string)($b['slug']??''),owner_id()]);json(['ok'=>true]);}
json(['error'=>'Unknown action'],404);
}catch(Throwable $e){http_response_code(500);echo json_encode(['error'=>'Database/PHP error. Make sure PDO SQLite is enabled and data/ is writable.']);}
