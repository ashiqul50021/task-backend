@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p>Producs</p>
                            <div>
                                <button class="btn btn-success" id="openModalButton">Import
                                    csv</button>
                                <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table class="table">
                            <thead>
                                <th>SL.</th>
                                <th>Images</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img style="height: 50px; width: 50px"
                                                src="{{ asset($product->images[0]->image ?? '') }}" alt=""></td>
                                        <td>{{ $product->name ?? 'N/A' }}</td>
                                        <td>{{ $product->description ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary"><i
                                                    class="fa-solid fa-eye"></i></a>
                                            <a href="" class="btn btn-secondary"><i class="fa-solid fa-pen"></i></a>
                                            <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger"><i
                                                    class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Csv</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="csv_file" id="csv_file" class="form-control">
                        <button type="submit" class="btn btn-primary mt-2">Upload</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            $('#openModalButton').click(function() {
                $('#exampleModal').modal('show');
            });

            $('#closeModalButton').click(function() {
                $('#exampleModal').modal('hide');
            });


        });
    </script>
@endsection
