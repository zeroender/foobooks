@foreach ($tagsForCheckboxes as $id => $name)
    <input
        type='checkbox'
        value='{{ $id }}'
        name='tags[]'
        {{ (isset($tagsForThisBook) and in_array($name, $tagsForThisBook)) ? 'CHECKED' : '' }}
    >
    {{ $name }} <br>
@endforeach
