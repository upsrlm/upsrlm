<?php
// Usage: Run this script in Yii2 console or as a controller action to list all users and their roles

use common\models\User;
use common\models\master\MasterRole;

$users = User::find()->with('urole')->orderBy(['role' => SORT_ASC, 'name' => SORT_ASC])->all();

printf("%-5s %-25s %-20s %-30s %-20s %-10s\n", 'ID', 'Name', 'Username', 'Email', 'Role', 'Status');
echo str_repeat('-', 120) . "\n";
foreach ($users as $user) {
    $roleName = $user->urole ? $user->urole->role_name : $user->role;
    $status = $user->status == User::STATUS_ACTIVE ? 'Active' : 'Inactive';
    printf("%-5d %-25s %-20s %-30s %-20s %-10s\n",
        $user->id,
        $user->name,
        $user->username,
        $user->email,
        $roleName,
        $status
    );
}
