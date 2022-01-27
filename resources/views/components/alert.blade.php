@if(session()->has('status'))
<div class="alert alert-primary" role="alert">
    <strong>info:  </strong>{{ session()->get('status')}}
</div>
@endif