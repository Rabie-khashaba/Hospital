<div  >
    @if($selected_conversation)
        <div class="main-content-body main-content-body-chat">
            <div class="main-chat-header">
                <div class="main-img-user"><img alt="" src="{{URL::asset('dashboard/img/faces/9.jpg')}}"></div>
                <div class="main-chat-msg-name">
                    <h6>{{$receviverUser->name}}</h6><small>Last seen: {{$selected_conversation->created_at->diffForHumans()}}</small>
                </div>
                <nav class="nav">
                    <a class="nav-link" href=""><i class="icon ion-md-more"></i></a> <a class="nav-link" data-toggle="tooltip" href="" title="Call"><i class="icon ion-ios-call"></i></a> <a class="nav-link" data-toggle="tooltip" href="" title="Archive"><i class="icon ion-ios-filing"></i></a> <a class="nav-link" data-toggle="tooltip" href="" title="Trash"><i class="icon ion-md-trash"></i></a> <a class="nav-link" data-toggle="tooltip" href="" title="View Info"><i class="icon ion-md-information-circle"></i></a>
                </nav>
            </div><!-- main-chat-header -->
            <div class="main-chat-body" id="ChatBody">
                <div class="content-inner">

                    @foreach($messages as $message)
                        <div class="media {{$auth_email == $message->sender_email ? 'flex-row-reverse':''}}">
                            <div class="media-body">
                                <div class="main-msg-wrapper right">
                                    {{$message->body}}
                                </div>
                                <div>
                                    <span>{{$message->created_at->diffForHumans()}}</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach



                </div>
            </div>
        </div>
    @endif
</div>
