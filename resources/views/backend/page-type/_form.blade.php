<div class="row">
    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}

            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Name']) !!}

            @if ($errors->has('name'))
                <div class="ui pointing red basic label"> {{$errors->first('name')}}</div>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group {{ $errors->has('icon') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('icon', 'Icon', ['class' => 'control-label']) !!}

            {!! Form::text('icon', null, ['class' => 'form-control', 'placeholder'=>'Icon']) !!}

            @if ($errors->has('icon'))
                <div class="ui pointing red basic label"> {{$errors->first('icon')}}</div>
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

    <div class="col-md-6">
        <div class="form-group required {{ $errors->has('order_by') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('order_by', 'Order By', ['class' => 'control-label']) !!}
            
            {!! Form::select('order_by', $order_by_lists, isset($page_type) ? $page_type->order_by : 1,['class' => 'form-control']) !!}

            @if ($errors->has('order_by'))
                <span class="help-block">
                    <strong>{{ $errors->first('order_by') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('menu_id') ? ' has-error' : '' }} clearfix ">
            {!! Form::label('menu_id', 'Menu', ['class' => 'control-label']) !!}

            <select name = "menu_id" class="form-control custom-select" placeholder = "Select the menu" style="width: 100%">
                <option></option>
                @foreach($menus as $menu)
                    @if(old('menu_id') != null)
                        <option value = "{{ $menu->id }}" @if($menu->id == old('menu_id')) selected @endif>
                            {{ $menu->name }} @if($menu->has_sub_menu == 0) (Primary Menu) @elseif($menu->has_sub_menu == 1) (Sub Menu) @endif
                        </option>
                    @elseif(isset($page_type->menu_id))
                        <option value = "{{ $menu->id }}" @if($page_type->menu_id == $menu->id) selected @endif>
                            {{ $menu->name }} @if($menu->has_sub_menu == 0) (Primary Menu) @elseif($menu->has_sub_menu == 1) (Sub Menu) @endif
                        </option>
                    @else
                        <option value = "{{ $menu->id }}">
                            {{ $menu->name }} @if($menu->has_sub_menu == 0) (Primary Menu) @elseif($menu->has_sub_menu == 1) (Sub Menu) @endif
                        </option>
                    @endif
                @endforeach
            </select>

            @if ($errors->has('menu_id'))
                <div class="ui pointing red basic label"> {{$errors->first('menu_id')}}</div>
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
                    {!! Form::checkbox('status', null, isset($page_type->status) ? $page_type->status : 1) !!}
                    <span class="toggle-slider round"></span>
                </label>
            </div>
            
            @if ($errors->has('status'))
                <div class="ui pointing red basic label"> {{$errors->first('status')}}</div>
            @endif
        </div>
    </div>
</div>