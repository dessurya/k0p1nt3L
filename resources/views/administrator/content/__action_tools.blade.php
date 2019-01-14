<div class="nav navbar-right panel_toolbox">
    <div class="btn-group">
      <a 
      	data-toggle='modal' 
      	data-target='.modal-add'
        data-href="{{ route('adm.mid.content.form', ['index'=>$index]) }}" 
        class="open btn btn-success btn-sm"
      >
        <i class="fa fa-plus"></i> Add {{ title_case(str_replace('-', ' ', $index)) }}
      </a>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-success">
        Administrator {{ $request->administrator != '' ? ' : '.$request->administrator : ' : All'}}
      </button>
      <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
        <span class="caret" style="color:white;"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li>
          <a href="{{ route('adm.mid.content', ['index'=>$index, 'administrator'=>'', 'status'=>$request->status, 'portofolio'=>$request->portofolio]) }}">
            Show All
          </a>
        </li>
        @php $lastAuthor = 0 @endphp
        @foreach($adm as $data)
        @if($lastAuthor != $data->id)
        <li>
          <a href="{{ route('adm.mid.content', ['index'=>$index, 'administrator'=>$data->email, 'status'=>$request->status, 'portofolio'=>$request->portofolio]) }}">
            {{ $data->name }}
          </a>
        </li>
        @endif
        @php $lastAuthor = $data->id @endphp
        @endforeach
      </ul>
    </div>
    @if($index != 'portofolio-galeri')
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-success">
        Status {{ $request->status != '' ? ' : '.title_case($request->status) : ' : All'}}
      </button>
      <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
        <span class="caret" style="color:white;"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li>
          <a href="{{ route('adm.mid.content', ['index'=>$index, 'administrator'=>$request->administrator, 'status'=>'']) }}">
            Show All
          </a>
        </li>
        <li>
          <a href="{{ route('adm.mid.content', ['index'=>$index, 'administrator'=>$request->administrator, 'status'=>'active']) }}">
            Active
          </a>
        </li>
        <li>
          <a href="{{ route('adm.mid.content', ['index'=>$index, 'administrator'=>$request->administrator, 'status'=>'deactive']) }}">
            Deactive
          </a>
        </li>
      </ul>
    </div>
    @endif
    @if($index == 'portofolio-galeri' and $listPG != null)
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-success">
        Portofolio {{ $request->portofolio != '' ? ' : '.$request->portofolio : ' : All'}}
      </button>
      <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
        <span class="caret" style="color:white;"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li>
          <a href="{{ route('adm.mid.content', ['index'=>$index, 'administrator'=>$request->administrator, 'portofolio'=>'']) }}">
            Show All
          </a>
        </li>
        <li>
          <a href="{{ route('adm.mid.content', ['index'=>$index, 'administrator'=>$request->administrator, 'portofolio'=>'unknown']) }}">
            Show Unknown
          </a>
        </li>
        @foreach($listPG as $data)
        <li>
          <a href="{{ route('adm.mid.content', ['index'=>$index, 'administrator'=>$request->administrator, 'portofolio'=>$data->slug]) }}">
            {{ $data->name_id }}
          </a>
        </li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="btn-group">
      <a 
        class="btn btn-success btn-sm"
        href="{{ route('adm.mid.content', ['index'=>$index]) }}" 
      >
        <i class="fa fa-refresh"></i> Clear Filter
      </a>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-sm btn-success">
        <i class="fa fa-cog"></i> Tools
      </button>
      <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown">
        <span class="caret" style="color:white;"></span>
      </button>
      <ul class="dropdown-menu" role="menu">
        <li>
          <a class="tools select-all" href="#">
            <i class="fa fa-check-square-o"></i> Select All
          </a>
        </li>
        <li>
          <a class="tools unselect-all" href="#">
            <i class="fa fa-square-o"></i> Unselect All
          </a>
        </li>
        @if($index != 'portofolio-galeri')
        <li>
          <a class="tools action activate" data-href="{{ route('adm.mid.content.action', ['index'=>$index, 'action'=>'activate'] ) }}" data-toggle='modal' data-target='.modal-aksi'>
            <i class="fa fa-check"></i> Activate
          </a>
        </li>
        <li>
          <a class="tools action deactivate" data-href="{{ route('adm.mid.content.action', ['index'=>$index, 'action'=>'deactivate']) }}" data-toggle='modal' data-target='.modal-aksi'>
            <i class="fa fa-ban"></i> Deactivate
          </a>
        </li>
        @elseif($index == 'portofolio-galeri')
        <li>
          <a class="tools action portofolio" data-href="{{ route('adm.mid.content.action', ['index'=>$index, 'action'=>'portofolio']) }}" data-toggle='modal' data-target='.modal-aksi'>
            <i class="fa fa-sitemap"></i> Set Portofolio
          </a>
        </li>
        @endif
        <li>
          <a class="tools action delete" data-href="{{ route('adm.mid.content.action', ['index'=>$index, 'action'=>'delete']) }}" data-toggle='modal' data-target='.modal-aksi'>
            <i class="fa fa-trash-o"></i> Delete
          </a>
        </li>
      </ul>
    </div>
</div>