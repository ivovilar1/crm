<div class="p-4">
    <ul class="flex flex-col gap-1">
        @foreach ($customer->tasks as $task)
            <li>
                <input id="task-{{ $task->id }}" type="checkbox" value="1" @if ($task->done_at) checked @endif />
                <label for="task-{{ $task->id }}">{{ $task->title }}</label>
                <select>
                    <option>assigned to: {{ $task->assignedTo?->name }}</option>
                </select>
            </li>
        @endforeach
    </ul>
    <hr class="border-dashed border-gray-700 my-4" />

    <ul class="flex flex-col gap-1">
        @foreach ($customer->tasks as $task)
            <li>
                <input id="task-{{ $task->id }}" type="checkbox" value="1" @if ($task->done_at) checked @endif />
                <label for="task-{{ $task->id }}">{{ $task->title }}</label>
                <select>
                    <option>assigned to: {{ $task->assignedTo?->name }}</option>
                </select>
            </li>
        @endforeach
    </ul>
</div>
