<div class="panel panel-default">
    <div class="panel-heading" role="tab" id="{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
        <h4 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}" aria-expanded="{{ $closed or 'true' }}"
               aria-controls="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
                {{ $title or 'Override Permissions' }} {!! isset($user) ? '<span class="text-danger">(' . $user->getDirectPermissions()->count() . ')</span>' : '' !!}
            </a>
        </h4>
    </div>
    <div id="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}" class="panel-collapse collapse {{ $closed or 'in' }}" role="tabpanel"
         aria-labelledby="dd-{{ isset($title) ? str_slug($title) :  'permissionHeading' }}">
        <div class="panel-body" style="padding-top:0px;">
            @foreach($permissions as $permission)
                <?php
                    $per_found = null;

                    if (isset($role)) {
                        $per_found = $role->hasPermissionTo($permission->name);
                    }

                    if (isset($user)) {
                        $per_found = $user->hasDirectPermission($permission->name);
                    }
                ?>

                <div class="col-md-3">
                    <div class="checkbox text-capitalize">
                        <label class="{{ str_contains($permission->name, 'delete') ? 'text-danger' : '' }}">
                            {!! Form::checkbox("permissions[]", $permission->name, $per_found, isset($options) ? $options : []) !!}
                            {{ str_replace('_', ' ', $permission->name) }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
