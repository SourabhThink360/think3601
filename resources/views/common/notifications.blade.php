@if(Session::has('message'))
  <div style="padding:11px;font-weight: 400;margin-top:30px" class="alert alert-success alert-dismissible text-center alertz">{{ Session::get('message') }}</div>
@endif
@if(Session::has('danger'))
  <div style="padding:11px;font-weight: 400;margin-top:30px" class="alert alert-danger alert-dismissible text-center alertz">{{ Session::get('danger') }}</div>
@endif



@if(Session::has('notification'))
    <div class="row alertz" id="alert2">
        <div class="alert alert-{{ Session::get('notification')['status'] == 'success' ? 'success' : 'danger'}} alert-dismissible fade in text-center">
            <span>{!! Session::get('notification')['message'] !!}</span>
        </div>
        <div class="clearfix"></div>
        <script type="text/javascript">
            $(function() {
                setTimeout(function(){
                    $("#alert2").hide();
                }, 5000);
            });
        </script>
    </div>


@endif
