@extends('admin.index')

@section('content')
    <h2 class="text-center">質問登録</h2>

    <x-utility-button href="{{ route('showEditQuestion') }}" class="secondary mb-3" icon="fa-solid fa-arrow-left me-2">
        戻る
    </x-utility-button>

    {{-- 質問作成完了メッセージ --}}
    @if (session('createQuestionMessage'))
        <div class="alert alert-success text-center">
            {{ session('createQuestionMessage') }}
        </div>
    @endif

    <div class="container mt-5">
        <div class="form-contents">
            <form action="{{ route('exeCreateQuestion') }}" method="post">
                @csrf
                <table class="mx-auto mt-3">
                    <tbody>
                        <tr>
                            <th class="mt-3">
                                <label class="me-3" for="content">質問内容</label>
                            </th>
                            <td>
                                <textarea class="form-control @error('content') is-invalid @enderror mt-3" name="content" id="content" cols="50" rows="3">{{ old('content') }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="category">カテゴリー</label>
                            </th>
                            <td>
                                <select class="form-select @error('category') is-invalid @enderror mt-5" name="category">
                                    <option disabled>選択してください</option>
                                    @foreach (App\Consts\CategoryConsts::CATEGORY_LIST as $num => $category)
                                        <option value="{{ $num }}">{{ $category }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>

                        <tr>
                            <th>
                                <label class="mt-5 me-3" for="role_id">対象職員(職位)</label>
                            </th>
                            <td>
                                <select class="form-select @error('role_id') is-invalid @enderror mt-5" name="role_id" aria-label="Default select example">
                                    <option disabled>選択してください</option>
                                    @foreach (App\Consts\StaffPositionConsts::STAFF_LIST as $num => $position)
                                        <option value={{ $num }}>{{ $position }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
        <div class="text-center">
            <button class="btn btn-primary mt-5 mx-auto" type="submit">登録</button>
        </div>
        </form>
    </div>
@endsection
