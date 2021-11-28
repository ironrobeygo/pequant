<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ $quiz->name }}</title>
</head>
<body>

    <p style="margin: 0;"><span style="font-weight: bold;">Name:</span> {{$student->name}}</p>
    <p style="margin: 0;"><span style="font-weight: bold;">Course:</span> {{$quiz->chapter->course->name}}</p>
    <p style="margin: 0;"><span style="font-weight: bold;">Chapter:</span> {{$quiz->chapter->name}}</p>
    <p style="margin: 0;"><span style="font-weight: bold;">Quiz:</span> {{$quiz->name}}</p>
    <hr>

    dd($questions);

    <ol>
    @foreach($questions as $question)
        <li>{!! $question->question !!}
            @if($complete == 0)
                @php
                    $marker = 'red';
                    $markerTitle = 'Incorrect';
                @endphp
                @if($answers[$question->id]['point'] >= 1)
                    @php
                        $marker = 'green';
                        $markerTitle = 'Correct';
                    @endphp
                @endif
                <span style='color:{!! $marker  !!}'>{{ $markerTitle }}</span>
            @endif

            @if($question->type_id == 1)
                <ul style="list-style: none; margin-left: 0; padding-left: 0; margin-top: 5px;">
                @php
                    $optionCounter = $question->options->pluck('answer')->filter(function($value, $key){
                        return $value == 1;
                    });

                    $type = $optionCounter->count() == 1 ? 'radio' : 'checkbox';

                @endphp

                @foreach($question->options as $option)
                    <li style="line-height: 0;">
                    @if($type == 'checkbox')
                        <input type="checkbox" style="margin-right: 2px;"{{ in_array($option->id,json_decode($answers[$question->id]['answer'])) ? ' checked ' : '' }} disabled>
                    @else
                        <input type="radio" style="margin-right: 2px;"{{ in_array($option->id,json_decode($answers[$question->id]['answer'])) ? ' checked ' : '' }} disabled>
                    @endif
                    <span style="display: inline-block; margin-top: -5px;">{{$option->value}}</span>
                    </li>
                @endforeach
                </ul>
            @endif

            @if($question->type_id == 2 || $question->type_id == 4)
                <p style="margin-top: 0;">Answer: {{$answers[$question->id]['answer']}}</p>
            @endif

            @if($question->type_id == 3)
                <a href="{{$student->getMedia('quiz')->where('id', $answers[$question->id]['answer'])->first()->getFullUrl()}}" target="_blank">Click to view to download file</a><br>
            @endif
                                    
            @php
                $count++;
            @endphp
        </li>
    @endforeach
    </ol>
</body>
</html>