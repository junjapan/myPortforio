<?php
mb_language("ja");
//mb_internal_encording("UTF-8");
// ここをかくにんするところからはじめる　https://oxynotes.com/?p=5970
if (mb_send_mail('watanabejapan2trap@gmail.com', 'test', 'test')) {
    print("送信成功");
} else {
    print("送信失敗");
}