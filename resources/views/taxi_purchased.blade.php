@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Купленные авто</h3>
            @foreach ($userTaxis as $userTaxi)
                <div class="col-md-4 mb-3">
                    <x-my-taxi-card :taxi="$userTaxi"></x-my-taxi-card>
                    <p>Текущий цвет: <span class="text-uppercase">{{ $userTaxi->color }}</span></p> <!-- Display current color -->
                    <button class="btn btn-primary" data-toggle="modal" data-target="#colorModal{{ $userTaxi->id }}">Сменить цвет</button>
                    <!-- Modal -->
                    <div class="modal fade" id="colorModal{{ $userTaxi->id }}" tabindex="-1" role="dialog" aria-labelledby="colorModalLabel{{ $userTaxi->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('change_color', $userTaxi->id) }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="colorModalLabel{{ $userTaxi->id }}">Выберите новый цвет</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="colorSelect{{ $userTaxi->id }}">Цвет:</label>
                                            <select name="new_color" id="colorSelect{{ $userTaxi->id }}" class="form-control">
                                                <option value="red">Красный</option>
                                                <option value="blue">Синий</option>
                                                <option value="yellow">Желтый</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                                        <button type="submit" class="btn btn-primary">Сменить цвет</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
