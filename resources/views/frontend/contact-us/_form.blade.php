<div class="form-group required {{ $errors->has('name') ? ' has-error' : '' }} clearfix ">
	<label class="control-label">Full Name</label>
	
	<input name="name" placeholder="Enter your name" class="common-input form-control" minlength="2" maxlenth="255" type="text" value="{{ old('name') }}" required>

	@if ($errors->has('name'))
        <span class="help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('email') ? ' has-error' : '' }} clearfix ">
	<label class="control-label">Email</label>

	<input name="email" placeholder="Enter your email address" class="common-input form-control" minlength="2" maxlenth="255" type="email" type="text" value="{{ old('email') }}" required>

	@if ($errors->has('email'))
        <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }} clearfix ">
	<label class="control-label">Contact Number</label>

	<input name="phone" placeholder="Enter your contact number" class="common-input form-control" minlength="5" maxlength="20" type="text" type="text" value="{{ old('phone') }}">

	@if ($errors->has('phone'))
        <span class="help-block">
            <strong>{{ $errors->first('phone') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }} clearfix ">
	<label class="control-label">Address</label>

	<input name="address" placeholder="Enter your address" class="common-input form-control" minlength="2" maxlenth="255" type="text" type="text" value="{{ old('address') }}">

	@if ($errors->has('address'))
        <span class="help-block">
            <strong>{{ $errors->first('address') }}</strong>
        </span>
    @endif
</div>

<div class="form-group {{ $errors->has('subject') ? ' has-error' : '' }} clearfix ">
    <label class="control-label">Subject</label>

    <input name="subject" type="text" class="form-control" minlength="2" maxlenth="255" placeholder="Subject" value="{{ old('subject') }}">

    @if ($errors->has('subject'))
        <span class="help-block">
            <strong>{{ $errors->first('subject') }}</strong>
        </span>
    @endif
</div>

<div class="form-group required {{ $errors->has('message') ? ' has-error' : '' }} clearfix ">
	<label class="control-label">Message</label>

	<textarea class="common-textarea form-control" name="message" placeholder="Messege" minlength="5" maxlenth="655356" rows="4" value="{{ old('message') }}" required></textarea>

	@if ($errors->has('message'))
        <span class="help-block">
            <strong>{{ $errors->first('message') }}</strong>
        </span>
    @endif
</div>