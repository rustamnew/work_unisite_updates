INSERT INTO `b_event_message` (`ID`, `TIMESTAMP_X`, `EVENT_NAME`, `LID`, `ACTIVE`, `EMAIL_FROM`, `EMAIL_TO`, `SUBJECT`, `MESSAGE`, `MESSAGE_PHP`, `BODY_TYPE`, `BCC`, `REPLY_TO`, `CC`, `IN_REPLY_TO`, `PRIORITY`, `FIELD1_NAME`, `FIELD1_VALUE`, `FIELD2_NAME`, `FIELD2_VALUE`, `SITE_TEMPLATE_ID`, `ADDITIONAL_FIELD`, `LANGUAGE_ID`) VALUES 
(form_id, '2021-07-18 19:23:19', 'FEEDBACK_FORM', 'site_id', 'Y', '#DEFAULT_EMAIL_FROM#', '#EMAIL_TO#', '#SITE_NAME#: Письмо через форму обратной связи', 'Информационное сообщение сайта #SITE_NAME# \r\n\r\nИмя: #AUTHOR# \r\n\r\n Телефон: #AUTHOR_PHONE# \r\n\r\nСообщение: #TEXT# \r\n\r\n\r\n Страница: #FORM_PAGE# \r\n Раздел: #FORM_SECTION# \r\n\r\n Форма: #FORM_TYPE#', 'Информационное сообщение сайта <?=$arParams["SITE_NAME"];?>\r\n \r\nИмя: <?=$arParams["AUTHOR"];?> \r\n\r\nТелефон: <?=$arParams["AUTHOR_PHONE"];?>\r\n\r\nСообщение: <?=$arParams["TEXT"];?> \r\n\r\n\r\n Страница: <?=$arParams["FORM_PAGE"];?> \r\n Раздел: <?=$arParams["FORM_SECTION"];?> \r\n\r\n Форма: <?=$arParams["FORM_TYPE"];?>', 'text', '', '', '', '', '', '', '', '', '', '', '', '');

INSERT INTO `b_event_message_site` (`EVENT_MESSAGE_ID`, `SITE_ID`) VALUES (form_id, 'site_id');