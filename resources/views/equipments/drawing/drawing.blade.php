@extends('layout.admin')
@section('css')


@stop
@section('title') Technical drawing for the equipment {{$equipment->code}} @endsection
@section('location-nav')
    <ol class="breadcrumb panel">
        <li><a href="{{url('/')}}">Dashboard</a></li>
        <li><a href="{{route('equipments.index')}}">Equipments management</a></li>
        <li><a href="{{route('technical-drawing',['equipment'=>$equipment->id])}}">Technical drawings management</a></li>
        <li class="active"><strong>Technical drawing</strong></li>
    </ol>
@endsection
@section('x_title')
    <h2>Images list</h2>
    <div class="clearfix"></div>
@endsection
@section('content')
    <div class="row">

        <div class="row">
            @foreach($equipment->drawings as $drawing)
                <div class="col-lg-3 col-md-4 col-xs-6">
                    <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="{{$drawing->title}}"
                       data-image="{{asset('drawings/equipments/'.$drawing->path)}}"
                       data-target="#image-gallery">
                        <img class="img-thumbnail"
                             src="{{asset('drawings/equipments/'.$drawing->path)}}"
                             alt="{{$drawing->title}}">
                    </a>
                </div>
            @endforeach
        </div>


        <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="image-gallery-title"></h4>
                    </div>
                    <div class="modal-body">
                        <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                    </div>
                    <div class="modal-footer">
                        <center>
                            <button type="button" class="btn btn-secondary " id="show-previous-image"><i
                                        class="fa fa-arrow-left"></i>
                            </button>
                            <button type="button" id="show-next-image" class="btn btn-secondary "><i
                                        class="fa fa-arrow-right"></i>
                            </button>
                        </center>

                    </div>
                </div>
            </div>
        </div>


        {{--modal for  spare--}}
        <div class="modal fade bs-example-modal-payment" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm" style="width: 100%;height: 100%;">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close"><span
                                    aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel2">Show</h4>
                    </div>
                    <div class="modal-body">
                        <img src="{{asset('emplys/images/1544212718.jpg')}}">
                    </div>
                    <form id="delete_payment_form" method="post">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close
                            </button>
                            {{csrf_field()}}
                            {{method_field('delete')}}
                            <button type="submit" class="btn btn-danger">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- / end  spare's modals -->
    </div>
@stop

@section('script')

    <script>
        let modalId = $('#image-gallery');

        $(document)
            .ready(function () {

                loadGallery(true, 'a.thumbnail');

                //This function disables buttons when needed
                function disableButtons(counter_max, counter_current) {
                    $('#show-previous-image, #show-next-image')
                        .show();
                    if (counter_max === counter_current) {
                        $('#show-next-image')
                            .hide();
                    } else if (counter_current === 1) {
                        $('#show-previous-image')
                            .hide();
                    }
                }

                /**
                 *
                 * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
                 * @param setClickAttr  Sets the attribute for the click handler.
                 */

                function loadGallery(setIDs, setClickAttr) {
                    let current_image,
                        selector,
                        counter = 0;

                    $('#show-next-image, #show-previous-image')
                        .click(function () {
                            if ($(this)
                                .attr('id') === 'show-previous-image') {
                                current_image--;
                            } else {
                                current_image++;
                            }

                            selector = $('[data-image-id="' + current_image + '"]');
                            updateGallery(selector);
                        });

                    function updateGallery(selector) {
                        let $sel = selector;
                        current_image = $sel.data('image-id');
                        $('#image-gallery-title')
                            .text($sel.data('title'));
                        $('#image-gallery-image')
                            .attr('src', $sel.data('image'));
                        disableButtons(counter, $sel.data('image-id'));
                    }

                    if (setIDs == true) {
                        $('[data-image-id]')
                            .each(function () {
                                counter++;
                                $(this)
                                    .attr('data-image-id', counter);
                            });
                    }
                    $(setClickAttr)
                        .on('click', function () {
                            updateGallery($(this));
                        });
                }
            });

        // build key actions
        $(document)
            .keydown(function (e) {
                switch (e.which) {
                    case 37: // left
                        if ((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
                            $('#show-previous-image')
                                .click();
                        }
                        break;

                    case 39: // right
                        if ((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
                            $('#show-next-image')
                                .click();
                        }
                        break;

                    default:
                        return; // exit this handler for other keys
                }
                e.preventDefault(); // prevent the default action (scroll / move caret)
            });
    </script>
@stop