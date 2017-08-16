<?php
	define('_C_REQUIRES', true);

	require SYS_LIBS_PATH . 'lib.php';

        require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/buffers/interfaces.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/patterns/interfaces.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/models/hierarchy/interfaces.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/models/data/interfaces.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/models/events/interfaces.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/messages/interfaces.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/utils/translators/interfaces.php';

	require SYS_LIBS_PATH . 'security.php';
	
	require SYS_LIBS_PATH . 'system.php';
	require SYS_LIBS_PATH . 'def_macroses.php';
	require SYS_LIBS_PATH . 'autoload.php';
	require SYS_LIBS_PATH . 'uuid.php';
	
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/patterns/singletone.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/patterns/umiEntinty.php';

	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/entities/exceptions/baseException.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/entities/exceptions/coreException.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/entities/exceptions/databaseException.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/entities/exceptions/privateException.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/entities/exceptions/publicException.php';

	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/database/ConnectionPool.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/database/IConnection.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/database/IQueryResult.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/database/mysqlConnection.php';
	require SYS_KERNEL_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/subsystems/database/mysqlQueryResult.php';

        require SYS_DEF_MODULE_PATH . '/var/www/semero/data/www/shop.kalyan-hut.ru/classes/modules/def_module.php';

	require SYS_KERNEL_PATH . "/var/www/semero/data/www/shop.kalyan-hut.ru/classes/system/utils/translators/translatorWrapper.php";
	require SYS_LIBS_PATH . 'streams.php';
?>
