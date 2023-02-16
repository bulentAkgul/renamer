# Renamer

This is a quite handy to rename files and folders. It'll not only rename, but also update all files that use the changed names. When a directory is renamed, the namespaces will be updated respectfully.

If you make a mistake, you can use "undo-log" command which is shipped by [**File History**](https://github.com/bulentAkgul/file-history) to rollback the changes.

There is one thing worth mentioning. In the case of multiple files/folders in the same name, they all will be renamed.

#### DISCLAIMER
Since this package will mess with your files, never use it before backup your code.

## Installation
```
sail composer require bakgul/renamer --dev
```
Next, you need to publish the settings by executing the following command.

```
sail artisan vendor:publish --provider="Bakgul\Renamer\RenamerServiceProvider"
```

## Commands

```
sail artisan rename {from} {to} {--f|folder}
```

### Arguments

-   **from**: a file or folder name. Extention can be specified like "MyClass.php" but "php" is default extention.
-   **to**: the new file or folder name. Extention will be the same as from's extention unless it's specified here like "MyNewClass.js"

### Options

-   **folder**: When this is true, renaming will be performed on folders.