<h2>Software Versions</h2>

<ul class="versions-ul">
@forelse($software_versions as $sv)
    <li>
        <span class="version-display-edit-box" data-url="{!! route("software.versionsedit", array('software'=>$software,'software_version'=>$sv->id)) !!}">{!! $sv->version !!}</span>
        {{--<div class="btn-group inline pull-right" data-toggle="buttons-checkbox">--}}
            {{--<div class="btn btn-warning btn-small edit-version">Edit</div>--}}
            {{--<div class="btn btn-primary btn-small save-edit-version" style="display: none;">Save</div>--}}
            {{--<div class="btn btn-danger btn-small cancel-edit-version" style="display: none;">Cancel</div>--}}
            {{--<div class="btn btn-danger btn-small delete-version">Delete</div>--}}
        {{--</div>--}}
    </li>
@empty
    <li>No versions of this software registered yet! Add one below</li>
@endforelse
</ul>

{{--{!! BootForm::open(array('url'=>route('software.versions', array('software'=>$software->slug)), 'class' => 'version-form')) !!}--}}
{{--<div class="form-group">--}}
    {{--<div>--}}
        {{--<button type="button" class="btn btn-success add-version"><span class="glyphicon glyphicon-plus"></span> Add a version</button>--}}
    {{--</div>--}}
{{--</div>--}}
{{--{!! BootForm::submit('Save New Software Version', array("class"=>"btn btn-primary btn-md save-new-software-version", "style"=>"display: none;")) !!}--}}
{{--{!! BootForm::close() !!}--}}

<br>

<h2>VM-Software Versions</h2>

<br>

{!! $errors->first('Version Pairing', '
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <strong>Error:</strong> :message
    <br> VM Version: ' . $errors->first('vm_name') . " already includes software version: " . $errors->first('software_name') .
    '
</div>
') !!}


<table class="table" id="table">
    <thead>
    <tr class="filters">
        <th>VM Version</th>
        <th>Software Versions Included</th>
    </tr>
    </thead>
    <tbody>
    @forelse($vm_versions as $vm)
        <tr>
            <td>{!! $vm->name() !!}</td>
            <td>

                @forelse($vm->softwareVersions()->where("software_id", "=", $software->id)->get() as $sv)
                    {!! $sv->version !!}<span class="table-comma">,</span>  {{-- trailing commas hidden in edit_software.css --}}
                @empty
                @endforelse

            </td>
        </tr>
    @empty
        <tr>
            {{--<td>No VMs yet! <a href="{!! route('vm.create') !!}">Create one here</a></td>--}}
            <td>
        </tr>
    @endforelse
    </tbody>
</table>


{{--<div id="software-pair-template" class="software-pair-container">--}}
    {{--{!! BootForm::open(array('url'=>route('software.vm-software', array('software'=>$software->slug)), 'class' => 'version-pair-form')) !!}--}}

    {{--{!! BootForm::select('vm_version', "VM version",--}}
        {{--$vm_versions_for_select, null, array()) !!}--}}

    {{--{!! BootForm::select('software_version', "includes software version",--}}
        {{--$software_versions_for_select, null, array()) !!}--}}

    {{--{!! BootForm::submit('Save Version Pair', array("class"=>"btn btn-primary btn-md")) !!}--}}
    {{--<button type="button" class="btn btn-danger versions-pair-cancel">Cancel</button>--}}
    {{--{!! BootForm::close() !!}--}}
{{--</div>--}}


{{--@unless( $software_versions->isEmpty() )--}}
    {{--<p>Use the list below to add or delete version pairs from the table.</p>--}}
    {{--<br>--}}
{{--@endunless--}}


<ul class="versions-ul wide">
@forelse($software_versions as $sv)
        @foreach($sv->VMVersions()->get() as $vm)
            <li>
                <span class="pair-text">VM Version: <span style="font-weight: bold;">{!! $vm->name() !!}</span>
                includes Software Version <span style="font-weight: bold;">{!! $sv->version !!}</span></span>
                {{--<div class="btn btn-danger btn-small delete-pair pull-right"--}}
                     {{--data-url="{!! route('software.vm-software.delete', array('software'=>$software->slug, "vm"=>$vm->id,--}}
                     {{--"software_version"=>$sv->id)) !!}">--}}
                    {{--Delete Pair--}}
                {{--</div>--}}
            </li>
        @endforeach
@empty
    <p>Version Pairs will appear below in written as you create them</p>
@endforelse
</ul>


{{--<div class="form-group">--}}
    {{--<div>--}}
        {{--<button type="button" class="btn btn-success add-version-pair">--}}
            {{--<span class="glyphicon glyphicon-plus"></span>--}}
            {{--Add a VM-Software version pair</button>--}}
    {{--</div>--}}
{{--</div>--}}