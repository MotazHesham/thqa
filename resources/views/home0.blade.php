
    
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="{{ $settings1['column_class'] }}">
                                <div class="card text-white bg-primary">
                                    <div class="card-body pb-0">
                                        <div class="text-value"></div>
                                        <div></div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                            <div class="{{ $settings2['column_class'] }}">
                                <div class="card text-white bg-primary">
                                    <div class="card-body pb-0">
                                        <div class="text-value"></div>
                                        <div></div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                            <div class="{{ $settings3['column_class'] }}">
                                <div class="card text-white bg-primary">
                                    <div class="card-body pb-0">
                                        <div class="text-value"></div>
                                        <div></div>
                                        <br />
                                    </div>
                                </div>
                            </div>
                            {{-- Widget - latest entries --}}
                            <div class="{{ $settings4['column_class'] }}" style="overflow-x: auto;">
                                <h3>{{ $settings4['chart_title'] }}</h3>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            @foreach ($settings4['fields'] as $key => $value)
                                                <th>
                                                    {{ trans(sprintf('cruds.%s.fields.%s', $settings4['translation_key'] ?? 'pleaseUpdateWidget', $key)) }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($settings4['data'] as $entry)
                                            <tr>
                                                @foreach ($settings4['fields'] as $key => $value)
                                                    <td>
                                                        @if ($value === '')
                                                            {{ $entry->{$key} }}
                                                        @elseif(is_iterable($entry->{$key}))
                                                            @foreach ($entry->{$key} as $subEentry)
                                                                <span
                                                                    class="label label-info">{{ $subEentry->{$value} }}</span>
                                                            @endforeach
                                                        @else
                                                            {{ data_get($entry, $key . '.' . $value) }}
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ count($settings4['fields']) }}">
                                                    {{ __('No entries found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            {{-- Widget - latest entries --}}
                            <div class="{{ $settings5['column_class'] }}" style="overflow-x: auto;">
                                <h3>{{ $settings5['chart_title'] }}</h3>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            @foreach ($settings5['fields'] as $key => $value)
                                                <th>
                                                    {{ trans(sprintf('cruds.%s.fields.%s', $settings5['translation_key'] ?? 'pleaseUpdateWidget', $key)) }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($settings5['data'] as $entry)
                                            <tr>
                                                @foreach ($settings5['fields'] as $key => $value)
                                                    <td>
                                                        @if ($value === '')
                                                            {{ $entry->{$key} }}
                                                        @elseif(is_iterable($entry->{$key}))
                                                            @foreach ($entry->{$key} as $subEentry)
                                                                <span
                                                                    class="label label-info">{{ $subEentry->{$value} }}</span>
                                                            @endforeach
                                                        @else
                                                            {{ data_get($entry, $key . '.' . $value) }}
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ count($settings5['fields']) }}">
                                                    {{ __('No entries found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>