@extends('layout')

@section('title', 'Detalles de un usuario')

@section('content')

    <div class="card">
        <div class="card-header h4">
            Crear nuevo usuario
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <h6>Por favor, corrige los siguientes errores</h6>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control"/>
                    {{--        @if($errors->has('name'))--}}
                    {{--            <p>{{ $errors->first('name') }}</p>--}}
                    {{--        @endif--}}
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico:</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control"/>
                    {{--        @if($errors->has('email'))--}}
                    {{--            <p>{{ $errors->first('email') }}</p>--}}
                    {{--        @endif--}}
                </div>

                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="password" class="form-control"/>
                    {{--        @if($errors->has('password'))--}}
                    {{--            <p>{{ $errors->first('password') }}</p>--}}
                    {{--        @endif--}}
                </div>

                <div class="form-group">
                    <label for="bio">Biografia</label>
                    <textarea type="text" name="bio" class="form-control">{{ old('bio') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="twitter">Twitter</label>
                    <input type="text" name="twitter" class="form-control" value="{{ old('twitter') }}"
                           placeholder="URL de tu usuario de twitter">
                </div>

                <div class="form-froup">
                    <label for="profession_id">Profesión</label>
                    <select name="profession_id" id="profession_id" class="form-control">
                        <option value="">Selecciona una opción</option>
                        @foreach($professions as $profession)
                            <option value="{{ $profession->id }}"
                                    {{ old('profession_id') == $profession->id ? 'selected' : '' }}
                            >{{ $profession->title }}</option>
                        @endforeach
                    </select>
                </div>

                <h5>Habilidades</h5>

                @foreach($skills as $skill)
                <div class="form-check form-check-inline">
                    <input name="skills[{{ $skill->id }}]" class="form-check-input" type="checkbox"
                           id="skill_{{ $skill->id }}" value="{{ $skill->id }}"
                            {{ old('skills.' . $skill->id) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $skill->id }}">{{ $skill->name }}</label>
                </div>
                @endforeach

                <div class="form-group mt-4">
                    <button type="submit">Crear usuario</button>
                    <a href="{{ route('users.index') }}" class="btn btn-link">Regresar al listado de usuarios</a>
                </div>

            </form>
        </div>
    </div>

@endsection