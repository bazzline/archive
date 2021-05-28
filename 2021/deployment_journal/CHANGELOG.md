# Change Log

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Open]

### To Add

* create domains
    * commit handler
        * execute as shell script
        * output on the command line
    * revert handler
        * execute as shell script
        * output on the command line
    * shipped with implementation
        * entity (json)
        * storage (file system)
* create zf console commands
    * environment list
    * task-handler list
* convert bin/commands to zf console commands
    * entity-create
    * system-adjust
    * system-audit
* convert filesystem storage to use flysystem
* implement code for domain storage comparator (compares content of two given storage)
* implement code for domain unified journal (what is a task, fetch list of task, fetch single task, add single task, delete single task - just the interfaces)
* implement code for domain shipped with journal (local file path storage)
* implement code for domain journal comparator (compares to different paths)
* implement code for domain commit handler (what has to be executed to commit a task - execute task if possible, on success copy it to the local storage)
* implement code for domain revert handler (what has to be executed to revert a task - execute undo if possible, on success remove it from the local storage)
* create lovely cli
    * https://docs.zendframework.com/zend-expressive/reference/cli-tooling/
    * https://xtreamwayz.com/blog/2016-02-07-zend-expressive-console-cli-commands
    * create entity -> ask to use the $EDITOR
* put each domain code into a dedicated repository
* put generic/feature related code to dedicated repository (or multiple)
* ask to rename this as täptn's log

## [In Progress]

### To Add

* when creating an entry
    * create a directory for each entry and move the task file to this
    * implement easier way to either provide relative or full qualified path to the task file

### To Change

## [Unreleased]

### Added

* added name to the entity
* created command line calls
    * entity create
    * entity list [--all] [--local] [--global]
    * system adjust
    * system audit
* create domains

### Changed

* move CreateController::fetchParameterValue into dedicated class to ease up unit testing
