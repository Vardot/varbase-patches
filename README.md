# Storage of Local Patches Branch

This branch is a storage for the list of needed local patches.

One a patch is added, never to be deleted
New patches should follow the following in the name of the patch file

`[package name]--[Date]--[issue number]-[comment number]--[MR number/commit number].patch`

Branch name for the package could be added too.

This will be a copy of Merge Request (MR), as it is important not to add `.diff` or `.patch` link to an MR as the code could change in anytime.


## Examples:

`drupal-core--2024-01-09--3049332-85.patch`

`drupal-core--10-2-x--3046152-49.patch`

`rabbit_hole--2024-02-04--3419073-3.patch`

`ui_patterns_settings--2023-12-17--3409221-3--mr-21--39e896da.patch`


## Reasons

Adding a direct MR as a patch is not the best option, for keeping a stable solution.

As Drupal is switching from patching to MRs

> While you are making the above changes, we recommend that you convert this patch to a merge request. Merge requests are preferred over patches. Be sure to hide the old patch files as well. (Converting an issue to a merge request without other contributions to the issue will not receive credit.)

Because of that needed patches from MRs will be hosted in this storage branch.
