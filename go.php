<?php
require __DIR__.'/lib.php';$slug=(string)($_GET['slug']??'');if(!preg_match('/^[A-Za-z0-9_-]+$/',$slug)){http_response_code(404);exit('Link not found');}$q=db()->prepare('SELECT destination FROM links WHERE slug=? LIMIT 1');$q->execute([$slug]);$r=$q->fetch(PDO::FETCH_ASSOC);if(!$r){http_response_code(404);exit('Link not found');}header('Location: '.$r['destination'],true,301);exit;
