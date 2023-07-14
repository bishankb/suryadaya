<div class="row">
    <div class="col-md-12">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Name']) !!}

            @if ($errors->has('name'))
                <div class="ui pointing red basic label"> {{$errors->first('name')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('positions') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('positions', 'Position', ['class' => 'control-label']) !!}

            @isset($menu)
                @php
                    $positionsData = explode(",", $menu->positions);
                @endphp
            @endisset
            
            {!! Form::select('positions[]', $positions, (isset($positionsData) ? $positionsData: null), ['class' => 'form-control custom-select', 'multiple' => 'multiple', 'data-placeholder' => 'Select Position', 'required' => 'required']) !!}

            @if ($errors->has('positions'))
                <span class="help-block">
                    <strong>{{ $errors->first('positions') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('icon') ? ' has-error' : '' }} clearfix ">
            <label class="control-label" for="icon">Icon
                <span style="color: red; font-size: 13px;">(Note: Only for Top Header and Bottom Navbar)</span>
            </label>

            {!! Form::text('icon', null, ['class' => 'form-control', 'placeholder'=>'Icon']) !!}

            @if ($errors->has('icon'))
                <div class="ui pointing red basic label"> {{$errors->first('icon')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('has_sub_menu') ? ' has-error' : '' }} clearfix ">
            <label class="control-label" for="has_sub_menu">Sub Menu
                <span style="color: red; font-size: 13px;">(Note: Only for Top Navbar)</span>
            </label>
            <div>
                <label class="toggle-switch">
                    {!! Form::checkbox('has_sub_menu', null, null, ['id' => 'has_sub_menu']) !!}
                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('has_sub_menu'))
                <div class="ui pointing red basic label"> {{$errors->first('has_sub_menu')}}</div>
            @endif
        </div>
    </div>
    
    <div class="col-md-6" id="menu_for_div">
        <div class="form-group {{ $errors->has('menu_for') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('menu_for', 'Menu For', ['class' => 'control-label']) !!}
           
            {!! Form::select('menu_for', $menu_for_lists, null, ['class' => 'form-control', 'placeholder' => 'Select the page type', 'id' => 'menu_for']) !!}

            @if ($errors->has('menu_for'))
                <span class="help-block">
                    <strong>{{ $errors->first('menu_for') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('order') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('order', 'Order', ['class' => 'control-label']) !!}

            {!! Form::number('order', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Order']) !!}

            @if ($errors->has('order'))
                <div class="ui pointing red basic label"> {{$errors->first('order')}}</div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('status') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('status', 'Status', ['class' => 'control-label']) !!}
            <div>
                <label class="toggle-switch">
                    {!! Form::checkbox('status', null, isset($menu->status) ? $menu->status : 1) !!}
                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('status'))
                <div class="ui pointing red basic label"> {{$errors->first('status')}}</div>
            @endif
        </div>
    </div>
</div>