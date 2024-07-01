
<select class="theme-input-style select2" id="city_id" name="city_id" required  >
    @foreach($cities as $id => $entry)
        <option value="{{ $id }}" {{ (old('city_id') ? old('city_id') : $building->city->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
    @endforeach
</select>