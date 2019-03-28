<?php

require_once __DIR__.'/connect.php';
$db->beginTransaction(); //*************************** all or nothing
$stmt = $db->prepare('UPDATE users SET balance = balance-10 WHERE email="a@a.com"');
if ( ! $stmt->execute() ) {
    echo 'Sorry, cannot update the user'.__LINE__;
    $db->rollback();
    exit();
}

$stmt = $db->prepare('UPDATE users SET balance = balance+10 WHERE email="b@b.com"');
if ( ! $stmt->execute() ) {
    echo 'Sorry, cannot update the user'.__LINE__;
    $db->rollback();
    exit();
}

$stmt = $db->prepare('INSERT INTO users VALUES (null, "j@j.com", 500)');
if( ! $stmt->execute() ){
    echo 'Cannot insert a user '.__LINE__;
    $db->rollBack();
    exit();
}

$stmt = $db->prepare('DELETE FROM users WHERE balance < 500');
if( ! $stmt->execute() ){
    echo 'Cannot delete user '.__LINE__;
    $db->rollBack();
    exit();
}

// SUCCESS
echo 'done';
$db->commit(); //***************************

//}catch(PDOException $ex){
//    echo 'FATAL ERROR';
//    echo $ex;
//}
