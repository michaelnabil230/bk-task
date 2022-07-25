<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Students of school ' . $school->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-link href="{{ route('dashboard.schools.students.create', $school) }}" class="mb-4">
                        {{ __('Add new school') }}
                    </x-link>
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left">
                                    {{ __('Name') }}
                                </th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($students as $student)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $student->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-link
                                            href="{{ route('dashboard.schools.students.edit', ['school' => $school, 'student' => $student]) }}">
                                            {{ __('Edit') }}</x-link>
                                        <x-link
                                            href="{{ route('dashboard.schools.students.show', ['school' => $school, 'student' => $student]) }}">
                                            {{ __('Show') }}</x-link>
                                        <form method="POST"
                                            action="{{ route('dashboard.schools.students.destroy', ['school' => $school, 'student' => $student]) }}"
                                            class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" onclick="return confirm('Are you sure?')">
                                                {{ __('Delete') }}
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b">
                                    <td colspan="3" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ __('No students found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-5">
                        {{ $students->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
