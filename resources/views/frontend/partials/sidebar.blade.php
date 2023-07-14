<div class="panel panel-success">
  <div class="panel-body news-section" style="background-color: #006c26; color: #9bc08c;">
    <div style="background-color: #9bc08c; width: 50%; color:#006c26 ">
      <h4>NEWS & UPDATES</h4>
    </div>

    @foreach($news_lists->take(4) as $news)
      <div class="single-news">
        <h5>
          <a style="color: #9bc08c;" href="{{ route('frontend.listPageDesc', $news->slug) }}">{{ $news->name }}</a>
        </h5>
        <p style="border-bottom: 1px solid; border-color: #6b9e56;">
          <i class="far fa-calendar"></i> {{ $news->created_at->format('Y/m/d') }}
        </p>
      </div>
    @endforeach

    <p class="know-more">
      <a href="{{ route('frontend.listPage', 'news') }}" style="color: #9bc08c;">More about News and Updates [..]</a>
    </p>
    
  </div>
</div>

<div class="panel panel-success" style="height:366px; overflow:auto;">
  <div class="panel-body" style="background-color: #336600; color: white;">
    <h4>CALL US</h4>
    <hr>
    @foreach($staffs as $staff)
      <div style="margin-bottom: 20px;">
        <h4 style="font-weight: normal;">{{ $staff->name }}</h4>
        <p style="color: #e2e2e2;">Position: {{ $staff->profile->position }}</p>
        <p style="color: #e2e2e2;">Phone Number: {{ $staff->profile->phone1 }}</p>
      </div>
    @endforeach
  </div>
</div>

<div class="panel panel-success">
  <div class="panel-body" style="background-color: #336600; color: white;">
    <h4>SOCIAL MEDIA</h4>
    <hr>
    <div class="fb-page" data-href="https://www.facebook.com/{{ config('suryadaya.facebook_page') }}" data-tabs="timeline" data-width="" data-height="220" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/{{ config('suryadaya.facebook_page') }}" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/{{ config('suryadaya.facebook_page') }}">{{ config('suryadaya.facebook_page') }}</a></blockquote></div>
  </div>
</div>