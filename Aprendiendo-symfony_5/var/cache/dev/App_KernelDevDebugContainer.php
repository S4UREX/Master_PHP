<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container1jw78kO\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container1jw78kO/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container1jw78kO.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container1jw78kO\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \Container1jw78kO\App_KernelDevDebugContainer([
    'container.build_hash' => '1jw78kO',
    'container.build_id' => 'b11743a8',
    'container.build_time' => 1593652870,
], __DIR__.\DIRECTORY_SEPARATOR.'Container1jw78kO');