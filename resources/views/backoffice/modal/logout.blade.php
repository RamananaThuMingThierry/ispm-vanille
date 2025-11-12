<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-success" id="logoutModalLabel">{{ __('logout.confirm_title') }}</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" class="text-danger">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p class="text-center">{{ __('logout.confirm_message') }}</p>
        </div>
        <div class="modal-footer">
          <button class="btn btn-danger rounded-0" type="button" data-dismiss="modal">{{ __('logout.cancel') }}</button>
          <form action="{{ route('logout') }}" method="post" class="d-inline">
            @csrf
            @method('POST')
            <button type="submit" class="btn btn-primary rounded-0">{{ __('logout.confirm_button') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
