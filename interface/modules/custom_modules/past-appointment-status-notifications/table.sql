
#IfNotRow2D background_services Appointment_Notifications
INSERT INTO `background_services` (`name`, `title`, `active`, `running`, `next_run`, `execute_interval`, `function`, `require_once`, `sort_order`) VALUES
    ('Appointment_Notifications', 'Pending Appointment Notifications', '1', '0', '2022-09-09 06:00:00', '1440', 'start_appt_notification', '/interface/modules/custom_modules/past-appointment-status-notifications/public/send_notification.php', '100');
#EndIf
