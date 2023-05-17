<?php
    //require dirname(__FILE__, 2) . "/src/jaas-jwt.php";
    ?>
<!DOCTYPE html>
<html>
<head>
    <script src='https://8x8.vc/vpaas-magic-cookie-02bc0019d5a3438186239dc1711e0ee1/external_api.js' async></script>
    <style>html, body, #jaas-container { height: 100%; }</style>
    <script type="text/javascript">
        window.onload = () => {
            const api = new JitsiMeetExternalAPI("8x8.vc", {
                roomName: "vpaas-magic-cookie-02bc0019d5a3438186239dc1711e0ee1/626",
                parentNode: document.querySelector('#jaas-container'),
                jwt: 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6InZwYWFzLW1hZ2ljLWNvb2tpZS0wMmJjMDAxOWQ1YTM0MzgxODYyMzlkYzE3MTFlMGVlMVwvZmU0NWViIn0.eyJpc3MiOiJjaGF0IiwiYXVkIjoiaml0c2kiLCJleHAiOjE2ODA1ODg4NzAsIm5iZiI6MTY4MDU4MTY3MCwicm9vbSI6IjYyNiIsInN1YiI6InZwYWFzLW1hZ2ljLWNvb2tpZS0wMmJjMDAxOWQ1YTM0MzgxODYyMzlkYzE3MTFlMGVlMSIsImNvbnRleHQiOnsidXNlciI6eyJtb2RlcmF0b3IiOiJ0cnVlIiwiZW1haWwiOiJzaGVyd2luZ2FkZGlzQGdtYWlsLmNvbSIsIm5hbWUiOiJTaGVyd2luIEdhZGRpcyIsImF2YXRhciI6IiIsImlkIjoiMTcxMWUwZWUxXC82NzRiYTcifSwiZmVhdHVyZXMiOnsicmVjb3JkaW5nIjoidHJ1ZSIsImxpdmVzdHJlYW1pbmciOiJ0cnVlIiwidHJhbnNjcmlwdGlvbiI6ImZhbHNlIiwib3V0Ym91bmQtY2FsbCI6ImZhbHNlIn19fQ.tfYv7zqurMCFardkUoCJ3By5mWvifEvAXrvb6XlKgFuFOtsE92sOUMhN2XBpBa_W7m8wvvwPJ5OwHrQthE8nta6aspd004tBoBHNVZLnwarLOjSfTLwNd_97X7v6txLc9eqPWuAKB6DU7U4eHr2FkY9VIPE5flW9drjpRtMe66CS3gAlF84xTHTvq3XGfKTjag3MTDQ2yqQCr9ezvoRc7fpE6qeRORTzpr2c8U99dOwhhdYBKLZY4mCb3ESEf8RixG1tu4AkQdHungcMoyiiYoFhhzdy9nGVY4KQ3R9SXRJXKIi0p0xECGAT5e40GyJmfGNNhH07_NxP1lgb23fhNuJ8RxcJR-H0d8KdSRvgFxLkalGfdt1qphvlWmTFpEOOqcuIeYpoovCB-1ffCvTA2zejttpvF7NK0tigjqdM3eLlch-CYAiUedwe347EQvvuGtdkDrQeKXvyBtDi2cq19zsr-cIvmDAYPzWffwNuy9yP8Oukr4drEMtTsc_EW35hsJ2WXGVWHrbtO9tvF70DD92hQBU4UlMVQv7yp8xllLYycaLuuVKWOsSbPWfCEj63Bio1xKFdx3NmzUoGb-hp5j43LH18yKlZbBm74fs0XXIFnsXdZJEGud3MfntvsewrbuNxgzmLjVuFshx-h9PSmWuJ8EVLFRwaR82bcJ5ZNcs'
            });
        }
    </script>
</head>
<body><div id="jaas-container" /></body>
</html>


