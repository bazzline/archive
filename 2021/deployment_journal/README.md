# Full Stop

I still like the idea but there is currently no use case to develop it anymore.

# Generic Deployment To Do System

Free as in freedom and generic approach to cover handling of deployment to does in a generic way.

# Benefits

* keep track of your deployment todo while switching branches

# Idea

* create file for each deployment todo into a global directory covered by the vcs
* just execute the deployment todo fitting to your environment
* record executed deployment todo into a local directory
* compare current local state with current global state
    * execute missing
    * revert not fitting

# Details

* each deployment todo has a uuid
* each deployment todo can cover one to many environments
* each deployment todo can be executed manually or automatically
* no fixed file format for a deployment to do
* decoupled from your used vcs since the vcs keeps track of the current state of all available deployment to dos

## Shipped with format

```javascript
//file with a name like "2a7f46c9-32ac-42b6-96e2-8fe2df51bdd8.json"
// in the global path like "<project root>/data/deployment_journal/global"
{
    "uuid": "<string>",
    "created_at": "<yyyy-mm-dd hh:ii:ss>",
    "created_by": "<name or unique identifier>",
    "list_of_affected_environments": [
        {
            "name": "development"
        },
        {
            "name": "production"
        },
        {
            "name": "staging"
        },
        {
            "name": "testing"
        }
    ],
    "name": "my example journal entry",
    "task_to_commit": {
        "class_name_of_handler": AApplication\\Feature\\DomainModel\\V1\\Service     "content": "#!/bin/bash",
        "description": "this is a demo entry"
    },
    "task_to_revert": {
        "class_name_of_handler": Application\\Feature\\DomainMApplication\\Feature\\DomainModel\\V1\\Service",
        "description": "this is a demo entry"
    }
    "version": "<integer>"
}
```

----------------

## won't do

# OLD

# Workflow

* use post-checkout and post-merge
* investigate current system status
    * read deployment to do list
    * read current branch name
    * read latest vcs commit id
    * read fitting (branch dependend) log
* compare deployment to does with steps in the local log
* output or handle deployment to do list entry
* commit each finished entry into the log
* save current git branch and latest commit
* remove local (branch dependend) log if branch is deleted via git ([post branch delete hook](http://stackoverflow.com/questions/14271989/git-branch-delete-hook#14285583)?)

# Scribbled Codes

## Configurable Settings

Either you add the relative path to the configuration file to each command or you put it into the path "\<project root>/configuration/deployment_journal/configuration.php".

```php
return [
    //uuid dns or url to replace uuid4 with uuid5
    'current_environment'           => <string>,
    'current_user_name'             => <string>,
    'execute_tasks_automatically'   => <boolean>,
    'list_of_environment'           => [
        '<string>',
        [<string,
        [...]]
    ],
    'path_to_the_global_journal'    => <string>,
    'path_to_the_local_journal'     => <string>
];
```

# Unordered Ideas

* entries can be stored in any kind of format
    * a generic interface is used to check if this entry needs to be committed or not
    * a generic interface is used to check if this entry needs to be reverted or not
* entries are stored as json files
* entries are stored in the directory path "\<yyyy>/\<mm>/\<dd>/\<uuid>.json"
* each done entry is copied to the local journal (the create date is the execution date)
* auditing the system means comparing the global and the local journal
* switching the  environment is not supported yet
* switching the data mapper is not supported yet
* entry can be done/committed or undone/reverted
* undo or revert a entry is a rollback?

## Next Milestone

* add archiving (zipping directories older than x days)
* add support for local.configuration.php an system.configuration.php to ease up maintaining 'current_environment' and 'current_user_name' from the rest.
* environment depended variables
* add --full to audit-system (to enable the list of entries in status "committed")

## To Do

* Filter by current environment in storage

## Nice To Have Or Just As Example

* configurable formatter/InputHandler/OutputHandler to start using this side beside your current project until you have migrated your infrastructure

# Things To Do

* find fitting cli environment to run with
* list of command
    * create-entry | entry-add|create - generates new entry
        * bin/entry-create
    * list-entries | entry-list - show all available entries with uuid, description and status (done, todo, to undo) - the log
    * audit-system | system-audit|check|review - validates if entries needs to be done or undone
    * update-system | system-fix|update|adjust|level|modulate|redeem|equalize - executes entries that needs to be done or undone

# Links

* https://en.wikipedia.org/wiki/Journal
* https://en.wikipedia.org/wiki/Journal_(disambiguation)
* https://en.wikipedia.org/wiki/Transaction_log
