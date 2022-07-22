<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
{{--{{dd($crud->promotion_locations)}}--}}

<label>Locations (<a href="{{ url('admin/locationpopup/create') }}" class="link-primary" id="Popup" >Create New</a>)</label>
<input type="hidden" id="usertier" />

@foreach($crud->promotion_locations as $ploc)
    <div class="form-check">

<input
    type="checkbox"
    name="{{ $field['name'] }}"
    class="form-check form-check-inline"
{{--    checked="1"--}}
    @if(isset($ploc['lid']))

    {{ ($ploc['lid']) ? "checked='true'" : " "}}

    @else
     checked="true"

    @endif

    value="{{$ploc['id']}}"
    @include('crud::fields.inc.attributes')
> {{ $ploc['location_name'] }}
    </div>

@endforeach
{{--<div class="form-check " id="loc-div" >--}}

{{--</div>--}}
<table class="form-table" id="loc-div">

</table>


@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS  --}}

    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- no styles -->
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <!-- no scripts -->
    @endpush
@endif
@include('crud::fields.inc.wrapper_end')
<!-- Modal -->

{{--<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" data-backdrop="false"  aria-hidden="true">--}}
{{--    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <h4 class="modal-title">Modal title</h4>--}}
{{--                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <div class="container-fluid">--}}
{{--                    <table class="table table-hover table-sm " id="loc_table">--}}
{{--                        <thead>--}}
{{--                        <tr>--}}
{{--                            <th scope="col">Select</th>--}}
{{--                            <th scope="col">Location Name</th>--}}
{{--                            <th scope="col">Address</th>--}}
{{--                            <th scope="col">Description</th>--}}
{{--                        </tr>--}}
{{--                        </thead>--}}
{{--                        <tbody>--}}
{{--                    @php--}}
{{--                        $i=1;--}}
{{--                        foreach ($crud->locations as $loc)--}}
{{--                        {--}}
{{--                    @endphp--}}
{{--                    <tr>--}}
{{--                        <td><input type="checkbox" value="{{$loc['id']}}" class='checkBoxClass' /></td>--}}
{{--                        <td>{{$loc['location_name']}}</td>--}}
{{--                        <td>{{$loc['location_address']}}</td>--}}
{{--                        <td>{{$loc['location_description']}}</td>--}}


{{--                        <td><a href="#" class="btn btn-primary" tabindex="-1" role="button" aria-disabled="true">View</a></td>--}}
{{--                    </tr>--}}
{{--                      @php--}}
{{--                         }--}}
{{--                     @endphp--}}

{{--                        </tbody>--}}
{{--                    </table>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="modal-footer">--}}
{{--                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
{{--                <button class="btn btn-primary" id="loc_btn" type="button" data-dismiss="modal">Save</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /.modal-content-->--}}
{{--    </div>--}}
{{--    <!-- /.modal-dialog-->--}}
{{--</div>--}}



