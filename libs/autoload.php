<?php
	global $includes;
	$includes = array();

	$includes = array(
		'regedit' => array(
			SYS_KERNEL_PATH . 'subsystems/regedit/iRegedit.php',
			SYS_KERNEL_PATH . 'subsystems/regedit/regedit.php'
		),

		'searchModel' => array(
			SYS_KERNEL_PATH . 'subsystems/models/search/iSearchModel.php',
			SYS_KERNEL_PATH . 'subsystems/models/search/searchModel.php'
		),

		'permissionsCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/permissions/iPermissionsCollection.php',
			SYS_KERNEL_PATH . 'subsystems/models/permissions/permissionsCollection.php'
		),

		'ranges' => array(
			SYS_KERNEL_PATH . 'utils/ranges/ranges.php'
		),

 		'translit' => array(
 			SYS_KERNEL_PATH . 'utils/translit/iTranslit.php',
 			SYS_KERNEL_PATH . 'utils/translit/translit.php'
 		),

 		'dbSchemeConverter' => array(
 			SYS_KERNEL_PATH . 'utils/dbSchemeConverter/iDbSchemeConverter.php',
 			SYS_KERNEL_PATH . 'utils/dbSchemeConverter/dbSchemeConverter.php'
 		),

 		'umiTarCreator' => array(
 			SYS_KERNEL_PATH . 'utils/tar/umiTarCreator.php'
 		),

 		'umiTarExtracter' => array(
 			SYS_KERNEL_PATH . 'utils/tar/umiTarExtracter.php'
 		),

		'adminModuleTabs' => array(
			SYS_KERNEL_PATH . 'utils/adminModuleTabs/iAdminModuleTabs.php',
			SYS_KERNEL_PATH . 'utils/adminModuleTabs/adminModuleTabs.php'
		),

		'umiTemplater' => array(
			SYS_KERNEL_PATH . 'subsystems/umiTemplaters/umiTemplater.php'
		),
		
		'umiTemplaterXSLT' => array(
			SYS_KERNEL_PATH . 'subsystems/umiTemplaters/types/umiTemplaterXSLT.php'
		),
		
		'umiTemplaterTPL' => array(
			SYS_KERNEL_PATH . 'subsystems/umiTemplaters/types/umiTemplaterTPL.php'
		),

		 /**
		  * @deprecated
		  */
		'templater' => array(
			SYS_KERNEL_PATH . 'subsystems/templaters/iTemplater.php',
			SYS_KERNEL_PATH . 'subsystems/templaters/templater.php'
		),

		/**
		 * @deprecated
		 */
		'tplTemplater' => array(
			SYS_KERNEL_PATH . 'subsystems/templaters/tpls/tplTemplater.php'
		),

		/**
		 * @deprecated
		 */
		'xslTemplater' => array(
			SYS_KERNEL_PATH . 'subsystems/templaters/xslt/xslTemplater.php'
		),

		/**
		 * @deprecated
		 */
		'xslAdminTemplater' => array(
			SYS_KERNEL_PATH . 'subsystems/templaters/xslt/xslAdminTemplater.php'
		),

		'cmsController' => array(
			SYS_KERNEL_PATH . 'subsystems/cmsController/iCmsController.php',
			SYS_KERNEL_PATH . 'subsystems/cmsController/cmsController.php'
		),


		/* export */
		'umiExporter' => array(
			SYS_KERNEL_PATH . 'subsystems/export/iUmiExporter.php',
			SYS_KERNEL_PATH . 'subsystems/export/umiExporter.php'
		),

		'xmlExporter' => array(
			SYS_KERNEL_PATH . 'subsystems/export/iXmlExporter.php',
			SYS_KERNEL_PATH . 'subsystems/export/xmlExporter.php'
		),

		/* Deprecated */
		'umiXmlExporter' => array(
			SYS_KERNEL_PATH . 'subsystems/export/iUmiXmlExporter.php',
			SYS_KERNEL_PATH . 'subsystems/export/umiXmlExporter.php'
		),

		/* import */

		/* Deprecated */
		'umiXmlImporter' => array(
			SYS_KERNEL_PATH . 'subsystems/import/iUmiXmlImporter.php',
			SYS_KERNEL_PATH . 'subsystems/import/umiXmlImporter.php'
		),

		'xmlImporter' => array(
			SYS_KERNEL_PATH . 'subsystems/import/iXmlImporter.php',
			SYS_KERNEL_PATH . 'subsystems/import/xmlImporter.php'
		),

		'umiImportRelations' => array(
			SYS_KERNEL_PATH . 'subsystems/import/iUmiImportRelations.php',
			SYS_KERNEL_PATH . 'subsystems/import/umiImportRelations.php'
		),

		'umiImportSplitter' => array(
			SYS_KERNEL_PATH . 'subsystems/import/iUmiImportSplitter.php',
			SYS_KERNEL_PATH . 'subsystems/import/umiImportSplitter.php'
		),

		'language_morph' => array(
			SYS_KERNEL_PATH . 'utils/languageMorph/iLanguageMorph.php',
			SYS_KERNEL_PATH . 'utils/languageMorph/language_morph.php'
		),

		'umiDate' => array(
			SYS_KERNEL_PATH . 'entities/umiDate/iUmiDate.php',
			SYS_KERNEL_PATH . 'entities/umiDate/umiDate.php'
		),

		'umiFile' => array(
			SYS_KERNEL_PATH . 'entities/umiFile/iUmiFile.php',
			SYS_KERNEL_PATH . 'entities/umiFile/umiFile.php'
		),

		'umiImageFile' => array(
			SYS_KERNEL_PATH . 'entities/umiFile/iUmiImageFile.php',
			SYS_KERNEL_PATH . 'entities/umiFile/umiImageFile.php'
		),

 		'umiRemoteFileGetter' => array(
 			SYS_KERNEL_PATH . 'entities/umiFile/umiRemoteFileGetter.php'
 		),

 		'umiDirectory' => array(
 			SYS_KERNEL_PATH . 'entities/umiDirectory/iUmiDirectory.php',
 			SYS_KERNEL_PATH . 'entities/umiDirectory/umiDirectory.php'
 		),

		'umiMail' => array(
			SYS_KERNEL_PATH . 'entities/umiMail/interfaces.php',
			SYS_KERNEL_PATH . 'entities/umiMail/umiMail.php',
			SYS_KERNEL_PATH . 'entities/umiMail/umiMimePart.php'
		),

		'umiBasket' => array(
			SYS_KERNEL_PATH . 'utils/basket/iUmiBasket.php',
			SYS_KERNEL_PATH . 'utils/basket/umiBasket.php'
		),

		'umiPagenum' => array(
			SYS_KERNEL_PATH . 'utils/pagenum/iPagenum.php',
			SYS_KERNEL_PATH . 'utils/pagenum/pagenum.php'
		),

		'umiCaptcha' => array(
			SYS_KERNEL_PATH . 'utils/captcha/iUmiCaptcha.php',
			SYS_KERNEL_PATH . 'utils/captcha/umiCaptcha.php'
		),

		'lang' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/lang.php'
		),


		'langsCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/langsCollection.php'
		),

		'domain' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/domainMirrow.php',
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/domain.php'
		),

		'domainsCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/domainsCollection.php'
		),

		'template' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/template.php'
		),

		'templatesCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/templatesCollection.php'
		),

		'umiHierarchyType' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/umiHierarchyType.php'
		),

		'umiHierarchyTypesCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/umiHierarchyTypesCollection.php'
		),

		'umiHierarchyElement' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/umiHierarchyElement.php'
		),

		'umiHierarchy' => array(
			SYS_KERNEL_PATH . 'subsystems/models/hierarchy/umiHierarchy.php'
		),

		'umiSelection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/selection/iUmiSelection.php',
			SYS_KERNEL_PATH . 'subsystems/models/selection/umiSelection.php'
		),

		'umiSelectionsParser' => array(
			SYS_KERNEL_PATH . 'subsystems/models/selection/iUmiSelectionsParser.php',
			SYS_KERNEL_PATH . 'subsystems/models/selection/umiSelectionsParser.php'
		),

		'umiFieldType' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiFieldType.php'
		),

		'umiField' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiField.php'
		),

		'umiFieldsGroup' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiFieldsGroup.php'
		),

		'umiObjectType' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiObjectType.php'
		),

		'umiObjectProperty' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiObjectProperty.php'
		),

		'umiObject' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiObject.php'
		),

		'umiFieldTypesCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiFieldTypesCollection.php'
		),

		'umiFieldsCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiFieldsCollection.php'
		),

		'umiObjectTypesCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiObjectTypesCollection.php'
		),

		'umiObjectsCollection' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/umiObjectsCollection.php'
		),

		'cacheFrontend' => array(
			SYS_KERNEL_PATH . 'subsystems/cache/iCacheFrontend.php',
			SYS_KERNEL_PATH . 'subsystems/cache/cacheFrontend.php'
		),

		'umiEventPoint' => array(
			SYS_KERNEL_PATH . 'subsystems/models/events/umiEventPoint.php'
		),

		'umiEventListener' => array(
			SYS_KERNEL_PATH . 'subsystems/models/events/umiEventListener.php'
		),

		'umiEventsController' => array(
			SYS_KERNEL_PATH . 'subsystems/models/events/umiEventsController.php'
		),
		
		'umiEventFeed' => array(
			SYS_KERNEL_PATH . 'subsystems/models/eventFeed/umiEventFeed.php'
		),

		'umiEventFeedType' => array(
			SYS_KERNEL_PATH . 'subsystems/models/eventFeed/umiEventFeedType.php'
		),

		'umiEventFeedUser' => array(
			SYS_KERNEL_PATH . 'subsystems/models/eventFeed/umiEventFeedUser.php'
		),

		'backupModel' => array(
			SYS_KERNEL_PATH . 'subsystems/models/backup/iBackupModel.php',
			SYS_KERNEL_PATH . 'subsystems/models/backup/backupModel.php'
		),

		'xmlTranslator' => array(
			SYS_KERNEL_PATH . 'utils/translators/xmlTranslator.php'
		),

		'jsonTranslator' => array(
			SYS_KERNEL_PATH . 'utils/translators/jsonTranslator.php'
		),

		'baseModuleAdmin' => array(
			SYS_DEF_MODULE_PATH . 'baseModuleAdmin.php'
		),

		'matches' => array(
			SYS_KERNEL_PATH . 'subsystems/matches/iMatches.php',
			SYS_KERNEL_PATH . 'subsystems/matches/matches.php'
		),

		'baseSerialize' => array(
			SYS_KERNEL_PATH . 'subsystems/matches/serializes/iBaseSerialize.php',
			SYS_KERNEL_PATH . 'subsystems/matches/serializes/baseSerialize.php'
		),

		'RSSFeed' => array(
			SYS_KERNEL_PATH . 'entities/RSS/interfaces.php',
			SYS_KERNEL_PATH . 'entities/RSS/RSSFeed.php',
			SYS_KERNEL_PATH . 'entities/RSS/RSSItem.php'
		),

		'umiCron' => array(
			SYS_KERNEL_PATH . 'subsystems/cron/iUmiCron.php',
			SYS_KERNEL_PATH . 'subsystems/cron/umiCron.php'
		),

		'umiMessages' => array(
			SYS_KERNEL_PATH . 'subsystems/messages/umiMessages.php'
		),

		'umiMessage' => array(
			SYS_KERNEL_PATH . 'subsystems/messages/umiMessage.php'
		),

		'umiSubscriber' => array(
			SYS_KERNEL_PATH . 'utils/subscriber/iUmiSubscriber.php',
			SYS_KERNEL_PATH . 'utils/subscriber/umiSubscriber.php'
		),

		'umiOpenSSL' => array(
			SYS_KERNEL_PATH . 'utils/openssl/iUmiOpenSSL.php',
			SYS_KERNEL_PATH . 'utils/openssl/umiOpenSSL.php'
		),

		'umiAuth' => array(
			SYS_KERNEL_PATH . 'subsystems/models/permissions/iUmiAuth.php',
			SYS_KERNEL_PATH . 'subsystems/models/permissions/umiAuth.php'
		),

		'umiLogger' => array(
			SYS_KERNEL_PATH . 'utils/logger/iLogger.php',
			SYS_KERNEL_PATH . 'utils/logger/logger.php'
		),

		'umiConversion' => array(
			SYS_KERNEL_PATH . 'utils/conversion/umiConversion.php',
			SYS_KERNEL_PATH . 'utils/conversion/iGenericConversion.php'
		),

		'garbageCollector' => array(
			SYS_KERNEL_PATH . 'subsystems/garbageCollector/iGarbageCollector.php',
			SYS_KERNEL_PATH . 'subsystems/garbageCollector/garbageCollector.php'
		),

		'PclZip' => array(
			SYS_KERNEL_PATH . 'entities/umiFile/pclzip.lib.php'
		),

		'manifest' => array(
			SYS_KERNEL_PATH . 'subsystems/manifest/classes/interfaces.php',
			SYS_KERNEL_PATH . 'subsystems/manifest/classes/manifest.php',
			SYS_KERNEL_PATH . 'subsystems/manifest/classes/sampleCallback.php',
			SYS_KERNEL_PATH . 'subsystems/manifest/classes/jsonCallback.php'
		),

		'transaction' => array(SYS_KERNEL_PATH . 'subsystems/manifest/classes/transaction.php'),

		'atomicAction' => array(SYS_KERNEL_PATH . 'subsystems/manifest/classes/atomicAction.php'),

		'umiBranch' => array(SYS_KERNEL_PATH . 'subsystems/models/data/umiBranch.php'),

		'umiObjectPropertyBoolean' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyBoolean.php'
		),

		'umiObjectPropertyImgFile' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyImgFile.php'
		),

		'umiObjectPropertyRelation' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyRelation.php'
		),

		'umiObjectPropertyTags' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyTags.php'
		),

		'umiObjectPropertyDate' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyDate.php'
		),

		'umiObjectPropertyInt' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyInt.php'
		),

		'umiObjectPropertyString' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyString.php'
		),

		'umiObjectPropertyText' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyText.php'
		),

		'umiObjectPropertyFile' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyFile.php'
		),

		'umiObjectPropertyPassword' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyPassword.php'
		),

		'umiObjectPropertyWYSIWYG' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyWYSIWYG.php'
		),

		'umiObjectPropertyFloat' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyFloat.php'
		),

		'umiObjectPropertyPrice' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyPrice.php'
		),

		'umiObjectPropertySymlink' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertySymlink.php'
		),

		'umiObjectPropertyCounter' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyCounter.php'
		),

		'umiObjectPropertyOptioned' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/properties/umiObjectPropertyOptioned.php'
		),

		'baseXmlConfig' => array(
			SYS_KERNEL_PATH . 'utils/xml/config/iBaseXmlConfig.php',
			SYS_KERNEL_PATH . 'utils/xml/config/baseXmlConfig.php'
		),

		'quickCsvExporter' => array(
			SYS_KERNEL_PATH . 'utils/csv/export/quickCsvExporter.php'
		),

		'quickCsvImporter' => array(
			SYS_KERNEL_PATH . 'utils/csv/import/quickCsvImporter.php'
		),

		'baseRestriction' => array(
			SYS_KERNEL_PATH . 'subsystems/models/data/baseRestriction.php'
		),

		'redirects' => array(
			SYS_KERNEL_PATH . 'subsystems/redirects/iRedirects.php',
			SYS_KERNEL_PATH . 'subsystems/redirects/redirects.php'
		),

		'umiBaseStream' => array(
			SYS_KERNEL_PATH . 'subsystems/streams/iUmiBaseStream.php',
			SYS_KERNEL_PATH . 'subsystems/streams/umiBaseStream.php'
		),

		'clusterCacheSync' => array(
			SYS_KERNEL_PATH . 'subsystems/cacheSync/clusterCacheSync.php'
		),

		'umiObjectProxy' => array(
			SYS_KERNEL_PATH . 'patterns/umiObjectProxy.php'
		),

		'umiObjectsExpiration' => array(
			SYS_KERNEL_PATH . 'subsystems/expirations/iUmiObjectsExpiration.php',
			SYS_KERNEL_PATH . 'subsystems/expirations/umiObjectsExpiration.php'
		),

		'HTTPOutputBuffer' => array(
			SYS_KERNEL_PATH . 'subsystems/buffers/HTTPOutputBuffer.php'
		),

		'CLIOutputBuffer' => array(
			SYS_KERNEL_PATH . 'subsystems/buffers/CLIOutputBuffer.php'
		),

		'objectProxyHelper' => array(
			SYS_KERNEL_PATH . 'patterns/objectProxyHelper.php'
		),

		'antiSpamService' => array(
			SYS_KERNEL_PATH . 'utils/antispam/antiSpamService.php'
		),

		'antiSpamHelper'  => array(
			SYS_KERNEL_PATH . 'utils/antispam/antiSpamHelper.php'
		),

		'alphabeticalIndex' => array(
			SYS_KERNEL_PATH . 'utils/indexes/alphabetical/alphabeticalIndex.php'
		),

		'calendarIndex' => array(
			SYS_KERNEL_PATH . 'utils/indexes/calendar/calendarIndex.php'
		),

		'selector' => array(
			SYS_KERNEL_PATH . 'subsystems/selector/selector.php',
			SYS_KERNEL_PATH . 'subsystems/selector/where.php',
			SYS_KERNEL_PATH . 'subsystems/selector/types.php',
			SYS_KERNEL_PATH . 'subsystems/selector/order.php',
			SYS_KERNEL_PATH . 'subsystems/selector/executor.php',
			SYS_KERNEL_PATH . 'subsystems/selector/getter.php',
			SYS_KERNEL_PATH . 'subsystems/selector/options.php',
			SYS_KERNEL_PATH . 'subsystems/selector/group.php'
		),

		'selectorHelper' => array(
			SYS_KERNEL_PATH . 'subsystems/selector/helper.php'
		),

		'loginzaAPI' => array(
			SYS_KERNEL_PATH . '/utils/loginza/loginzaAPI.class.php'
		),

		'loginzaUserProfile' => array(
			SYS_KERNEL_PATH . '/utils/loginza/loginzaUserProfile.class.php'
		),

		'session' => array(
			SYS_KERNEL_PATH . '/subsystems/session/interfaces.php',
			SYS_KERNEL_PATH . '/subsystems/session/session.php'
		)
	);
?>
