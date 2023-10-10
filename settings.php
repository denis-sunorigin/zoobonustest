<?php
	DEFINE ("DBHOST", "localhost");
	DEFINE ("DBUSER", "root");
	DEFINE ("DBPASS", "");
	DEFINE ("DBNAME", "zoobonustest102023");
	DEFINE ("DBPORT", "3306");

	DEFINE ("DEFAULTADMINPASSWORD", "8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918");

	DEFINE ("DEBUGLOG", true);
	DEFINE ("LOGFILE", "zbt.log"); // Під Linux краще зробити /var/log/test/....
	DEFINE ("TELEGATOKEN", "5089589916:AAHlMojaNoh1nKJwu9UIncU6lC5NV2mOP9g"); // 5089589916:AAHlMojaNoh1nKJwu9UIncU6lC5NV2mOP9g = serverEventsNotifierBot (Server event)
	DEFINE ("TELEGACHATID", "-4096958745"); // -4096958745 = Notifications
	DEFINE ("MAXTELEGAMESSAGELENGTH", 500);

	date_default_timezone_set('Europe/Kyiv');
	mysqli_report(MYSQLI_REPORT_STRICT);
?>
