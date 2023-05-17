#IfNotTable module_google_connect
CREATE TABLE `module_google_connect` (
 `id` int NOT NULL,
 `access_to` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
 `pid` bigint NOT NULL,
 `access_token` text COLLATE utf8mb4_general_ci NOT NULL,
 `refresh_token` text COLLATE utf8mb4_general_ci NOT NULL,
 `expires_in` int NOT NULL,
 `scope` text COLLATE utf8mb4_general_ci NOT NULL,
 `token_type` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
 `date` date NOT NULL,
 `updated` date NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
--
-- Indexes for table `module_google_connect`
--
ALTER TABLE `module_google_connect`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `module_google_connect`
--
ALTER TABLE `module_google_connect`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;
#EndIf
