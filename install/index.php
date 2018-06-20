<?
global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-18);
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

Class support extends CModule
{
	var $MODULE_ID = "support";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;

	function support()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = GetMessage("SUPPORT_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("SUPPORT_MODULE_DESC");
	}

        // Функция для создания поля инфоблока
	function AddProp($arFieldsProp) {
		CModule::IncludeModule("iblock");
		
		$ibp = new CIBlockProperty;
		$propID = $ibp->Add($arFieldsProp);
		
		return $propID;
	}

        // Функция для создания нового инфоблока
	function AddIBlock($arFieldsIB) {
		CModule::IncludeModule("iblock");
		
		$iblockCode = $arFieldsIB["CODE"];
		$iblockType = $arFieldsIB["TYPE"];
		
		$ib = new CIBlock;
		
		// Проверка, может инфоблок уже существует
		$resIBE = CIBlock::GetList(Array(), Array('TYPE' => $iblockType, "CODE" => $iblockCode));
		if ($ar_resIBE = $resIBE->Fetch()) {
			return false;  // Такой инфоблок уже есть
		}
		else
		{
			$ID = $ib->Add($arFieldsIB);
			$iblockID = $ID;
		}
		
		return $iblockID;
	
	}


        // Функция для создания нового типа инфоблока
	function AddIBlockType($arFieldsIBT) {
		global $DB;
		CModule::IncludeModule("iblock");
		
		$iblockType = $arFieldsIBT["ID"];
		
		// Проверяем, может такой тип инфоблока уже есть
		$db_iblock_type = CIBlockType::GetList(Array("SORT" => "ASC"), Array("ID" => $iblockType));
		// Если такого типа инфоблока нет, то создаем его
		if (!$ar_iblock_type = $db_iblock_type->Fetch()) {
			    $obBlockType = new CIBlockType;
			    $DB->StartTransaction();
			    $resIBT = $obBlockType->Add($arFieldsIBT);
			    if (!$resIBT) {
				    $DB->Rollback();
				    echo "Ошибка при создании нового типа инфоблока. " . $obBlocktype->LAST_ERROR . "\n";
				    die();
				    }
				    else
				    {
				    $DB->Commit();
				    };
			    }
			    else
			    {
			    return false;
			    };
			    
		return $iblockType;
	}

	function InstallIBlocks()
	{
		// Создаем новый тип инфоблока SUPPORT
		$arFieldsForType = Array(
		    'ID' => "support",
		    'SECTIONS' => 'Y',
		    'IN_RSS' => 'N',
		    'SORT' => 500,
		    'LANG' => Array (
			    'ru' => Array (
				    'NAME' => GetMessage("SUPPORT_IBLOCK_TYPE_NAME")
			    )
		    )
		);
		
		if ($this->AddIBlockType($arFieldsForType)){
		
		// Тип инфоблока создали, теперь создаем инфоблоки данного типа
		// Инфоблок "Авторы"
		$arFieldsForIBlockAuthors = Array(
			"ACTIVE" => "Y",
			"NAME" => GetMessage("SUPPORT_IBLOCK_NAME1"),
			"CODE" => "authors",
			"IBLOCK_TYPE_ID" => $arFieldsForType["ID"],
			"SITE_ID" => "s1",
			"GROUP_ID" => Array("2" => "R"),
			"FIELDS" => Array (
				"CODE" => Array (
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => Array(
						"TRANS_CASE" => "L",
						"UNIQUE" => "Y",
						"TRANSLITERATION" => "Y",
						"TRANS_SPACE" => "-",
						"TRANS_OTHER" => "-"
					)
				)
			)
		);

		// Инфоблок "Комментарии"
		$arFieldsForIBlockComments = Array(
			"ACTIVE" => "Y",
			"NAME" => GetMessage("SUPPORT_IBLOCK_NAME2"),
			"CODE" => "comments",
			"IBLOCK_TYPE_ID" => $arFieldsForType["ID"],
			"SITE_ID" => "s1",
			"GROUP_ID" => Array("2" => "R"),
			"FIELDS" => Array (
				"CODE" => Array (
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => Array(
						"TRANS_CASE" => "L",
						"UNIQUE" => "Y",
						"TRANSLITERATION" => "Y",
						"TRANS_SPACE" => "-",
						"TRANS_OTHER" => "-"
					)
				)
			)
		);
		
		// Инфоблок "Ответы"
		$arFieldsForIBlockAnswers = Array(
			"ACTIVE" => "Y",
			"NAME" => GetMessage("SUPPORT_IBLOCK_NAME3"),
			"CODE" => "answers",
			"IBLOCK_TYPE_ID" => $arFieldsForType["ID"],
			"SITE_ID" => "s1",
			"GROUP_ID" => Array("2" => "R"),
			"FIELDS" => Array (
				"CODE" => Array (
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => Array(
						"TRANS_CASE" => "L",
						"UNIQUE" => "Y",
						"TRANSLITERATION" => "Y",
						"TRANS_SPACE" => "-",
						"TRANS_OTHER" => "-"
					)
				)
			)
		);

		// Инфоблок "Вопросы"
		$arFieldsForIBlockQuestions = Array(
			"ACTIVE" => "Y",
			"NAME" => GetMessage("SUPPORT_IBLOCK_NAME4"),
			"CODE" => "questions",
			"IBLOCK_TYPE_ID" => $arFieldsForType["ID"],
			"SITE_ID" => "s1",
			"GROUP_ID" => Array("2" => "R"),
			"FIELDS" => Array (
				"CODE" => Array (
					"IS_REQUIRED" => "Y",
					"DEFAULT_VALUE" => Array(
						"TRANS_CASE" => "L",
						"UNIQUE" => "Y",
						"TRANSLITERATION" => "Y",
						"TRANS_SPACE" => "-",
						"TRANS_OTHER" => "-"
					)
				)
			)
		);

                $iblockID1 = $this->AddIBlock($arFieldsForIBlockAuthors);
	        $iblockID2 = $this->AddIBlock($arFieldsForIBlockComments);
                $iblockID3 = $this->AddIBlock($arFieldsForIBlockAnswers);
                $iblockID4 = $this->AddIBlock($arFieldsForIBlockQuestions);

		if ($iblockID1 && $iblockID2 && $iblockID3 && $iblockID4)  
		{
	
		// Теперь добавляем Инфоблокам необходимые свойства
		// Сначала инфоблоку Авторы
		
		// Поле "Имя"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_NAME"),
			"ACTIVE" => "Y",
			"SORT" => "1000",
			"CODE" => "name",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $iblockID1,
			);

		$this->AddProp($arFieldsProp);

		// Поле "Имейл"
		$arFieldsProp = Array(
			"NAME" =>  GetMessage("SUPPORT_IBLOCK_PROP_EMAIL"),
			"ACTIVE" => "Y",
			"SORT" => "1100",
			"CODE" => "email",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $iblockID1,
			);

		$this->AddProp($arFieldsProp);

		// Теперь инфоблоку Комментарии
		
		// Поле "Автор" (ссылка на инфоблок Авторы)
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_AUTHORCOM"),
			"ACTIVE" => "Y",
			"SORT" => "1000",
			"CODE" => "authorcom",
			"PROPERTY_TYPE" => "E",
			"IBLOCK_ID" => $iblockID2,
			"LINK_IBLOCK_ID" => $iblockID1
			);

		$this->AddProp($arFieldsProp);

		// Поле "Ответ" (ссылка на инфоблок Ответы)
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_ANSWER"),
			"ACTIVE" => "Y",
			"SORT" => "1100",
			"CODE" => "answer",
			"PROPERTY_TYPE" => "E",
			"IBLOCK_ID" => $iblockID2,
			"LINK_IBLOCK_ID" => $iblockID3
			);

		$this->AddProp($arFieldsProp);

		// Поле "Содержание комментария"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_INCCOM"),
			"ACTIVE" => "Y",
			"SORT" => "1200",
			"CODE" => "inccom",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $iblockID2,
			);

		$this->AddProp($arFieldsProp);

		// Поле "Дата"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_DATECOM"),
			"ACTIVE" => "Y",
			"SORT" => "1300",
			"CODE" => "datecom",
			"PROPERTY_TYPE" => "S",
			"USER_TYPE" => "DateTime",
			"IBLOCK_ID" => $iblockID2,
			);

		$this->AddProp($arFieldsProp);

		// Теперь инфоблоку Ответ
		
		// Поле "Автор" (ссылка на инфоблок Авторы)
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_AUTHORANS"),
			"ACTIVE" => "Y",
			"SORT" => "1000",
			"CODE" => "authorans",
			"PROPERTY_TYPE" => "E",
			"IBLOCK_ID" => $iblockID3,
			"LINK_IBLOCK_ID" => $iblockID1
			);

		$this->AddProp($arFieldsProp);

		// Поле "Вопрос" (ссылка на инфоблок Вопросы)
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_QUESTION"),
			"ACTIVE" => "Y",
			"SORT" => "1100",
			"CODE" => "question",
			"PROPERTY_TYPE" => "E",
			"IBLOCK_ID" => $iblockID3,
			"LINK_IBLOCK_ID" => $iblockID4
			);

		$this->AddProp($arFieldsProp);

		// Поле "Содержание ответа"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_INCANS"),
			"ACTIVE" => "Y",
			"SORT" => "1200",
			"CODE" => "incans",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $iblockID3,
			);

		$this->AddProp($arFieldsProp);

		// Поле "Дата"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_DATEANS"),
			"ACTIVE" => "Y",
			"SORT" => "1300",
			"CODE" => "dateans",
			"PROPERTY_TYPE" => "S",
			"USER_TYPE" => "DateTime",
			"IBLOCK_ID" => $iblockID3,
			);

		$this->AddProp($arFieldsProp);

		// И, наконец, инфоблоку Вопрос
		
		// Поле "Автор" (ссылка на инфоблок Авторы)
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_AUTHORQUES"),
			"ACTIVE" => "Y",
			"SORT" => "1000",
			"CODE" => "authorques",
			"PROPERTY_TYPE" => "E",
			"IBLOCK_ID" => $iblockID4,
			"LINK_IBLOCK_ID" => $iblockID1
			);

		$this->AddProp($arFieldsProp);

		// Поле "Содержание вопроса"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_INCQUES"),
			"ACTIVE" => "Y",
			"SORT" => "1200",
			"CODE" => "incques",
			"PROPERTY_TYPE" => "S",
			"IBLOCK_ID" => $iblockID4,
			);

		$this->AddProp($arFieldsProp);

		// Поле "Дата"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_DATEQUES"),
			"ACTIVE" => "Y",
			"SORT" => "1300",
			"CODE" => "dateques",
			"PROPERTY_TYPE" => "S",
			"USER_TYPE" => "DateTime",			
			"IBLOCK_ID" => $iblockID4,
			);

		$this->AddProp($arFieldsProp);

		// Поле "Активность"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_ACTQUES"),
			"ACTIVE" => "Y",
			"SORT" => "1400",
			"CODE" => "actques",
			"PROPERTY_TYPE" => "L",
			"LIST_TYPE" => "C",
			"IBLOCK_ID" => $iblockID4,
			"VALUES" => Array( Array ("VALUE" => "Y", "DEF" => "Y", "SORT" => "100" ) )
			);

		$this->AddProp($arFieldsProp);

		// Поле "Завершен"
		$arFieldsProp = Array(
			"NAME" => GetMessage("SUPPORT_IBLOCK_PROP_ENDQUES"),
			"ACTIVE" => "Y",
			"SORT" => "1500",
			"CODE" => "endques",
			"PROPERTY_TYPE" => "L",
			"LIST_TYPE" => "C",
			"IBLOCK_ID" => $iblockID4,
			"VALUES" => array(
			       Array ("VALUE" => "Y", "DEF" => "N", "SORT" => "100" )
			)
			);

		$this->AddProp($arFieldsProp);

		
		}
		else
		{
		    CAdminMessage::ShowMessage(Array(
			    "TYPE" => "ERROR",
			    "MESSAGE" => GetMessage("SUPPORT_IBLOCK_NOT_INSTALLED"),
			    "DETAILS" => "",
			    "HTML" => true
			    ));

		}
		}
		else
		{
		    CAdminMessage::ShowMessage(Array(
			    "TYPE" => "ERROR",
			    "MESSAGE" => GetMessage("SUPPORT_IBLOCK_TYPE_NOT_INSTALLED"),
			    "DETAILS" => "",
			    "HTML" => true
			    ));

		}
		
		return true;
	}

	function UnInstallIBlocks()
	{
		global $DB;
		CModule::IncludeModule("iblock");
		
		// Удаляем тип инфоблоков SUPPORT
		$DB->StartTransaction();
		if (!CIBlockType::Delete("support")) {
		    $DB->Rollback();
		    CAdminMessage::ShowMessage(Array(
			    "TYPE" => "ERROR",
			    "MESSAGE" => GetMessage("SUPPORT_IBLOCK_TYPE_DELETE_ERROR"),
			    "DETAILS" => "",
			    "HTML" => true
			    ));
		   }
		   $DB->Commit();
		   return true;
	}


	function InstallDB()
	{
		RegisterModule("support");
		return true;
	}

	function UnInstallDB()
	{
		UnRegisterModule("support");
		return true;
	}

	function InstallFiles($arParams = array())
	{
		CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/support/install/components",
		             $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);
		return true;
	}

	function UnInstallFiles()
	{
		DeleteDirFilesEx("/bitrix/components/support/");
		return true;
	}

	function DoInstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->InstallFiles();
		$this->InstallIBlocks();
		$this->InstallDB();
		$APPLICATION->IncludeAdminFile(GetMessage("SUPPORT_INSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/support/install/step.php");
	}

	function DoUninstall()
	{
		global $DOCUMENT_ROOT, $APPLICATION;
		$this->UnInstallFiles();
		$this->UnInstallIBlocks();
		$this->UnInstallDB();
		$APPLICATION->IncludeAdminFile(GetMessage("SUPPORT_UNINSTALL_TITLE"), $DOCUMENT_ROOT."/bitrix/modules/support/install/unstep.php");
	}
}
?>
