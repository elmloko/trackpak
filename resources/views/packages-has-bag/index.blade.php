@extends('layouts.app')

@section('template_title')
    Packages Has Bag
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Packages Has Bag') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('packages-has-bags.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>
                                        
										<th>Bags Id</th>
										<th>Packages Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packagesHasBags as $packagesHasBag)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            
											<td>{{ $packagesHasBag->bags_id }}</td>
											<td>{{ $packagesHasBag->packages_id }}</td>

                                            <td>
                                                <form action="{{ route('packages-has-bags.destroy',$packagesHasBag->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('packages-has-bags.show',$packagesHasBag->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('packages-has-bags.edit',$packagesHasBag->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $packagesHasBags->links() !!}
            </div>
        </div>
    </div>
@endsection
