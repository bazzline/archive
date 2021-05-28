
# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Open]

### To Add

* Create [ArchvieManager](source/Storage/ArchiveManager.php) to support archiving of old crontabs
    * use >>ls -hAlt | tail -n +<number of files to keep><<
* create unit test for [CrontabManager](source/Service/CrontabManager.php)
* create unit test for [CrontabService](source/Service/Crontab/CrontabService.php)
* create unit test for [Renderer](source/Service/Template/Renderer.php)
* create unit test for [SectionManager](source/Service/Crontab/SectionManager.php)
* implement [CrontabService::disableAll](source/Service/Crontab/CrontabService.php)
* add configuration value to make CrontabManager::COMMENT_PREFIX_IDENTIFIER configurable

### To Change

* change implementation of enable crontab and bring int in sync with disable crontab (remove '#' if exists)

## [Unreleased]

### Added

### Changed

## [0.0.1]() - released at yyyy-mm-dd

### Added

* Added console command >>crontab-manager audit [-v]<<
* Added console command >>crontab-manager enable full<<
* Added console command >>crontab-manager enable section<<
* Added console command >>crontab-manager disable full<<
* Added console command >>crontab-manager disable section<<
* Added console command >>crontab-manager list full<<
* Added console command >>crontab-manager list section<<
* Added console command >>crontab-manager update [-v]<<
* Added flag "-f" to console command >>crontab-manager update<< to force an update even if it is not needed

### Changed

* Implemented handling of no section found (install case)
* Implemented lockfile usage in [CrontabManager](source/Service/CrontabManager.php)
* Moved configuration to [Configuration](source/Model/Configuration/Configuration.php)
* Moved file logic from [CrontabManager](source/Service/CrontabManager.php) into [FileStorage](source/Service/Storage/FileStorage.php)
* Moved render logic from [CrontabManager](source/Service/CrontabManager.php) into [TemplateRenderer](source/Service/Template/Renderer.php)
* Moved crontab logic from [CrontabManager](source/Service/CrontabManager.php) into [CrontabService](source/Service/Crontab/CrontabService.php)
* Moved section logic from [CrontabManager](source/Service/CrontabManager.php) into [SectionManager](source/Service/Crontab/SectionManager.php)
