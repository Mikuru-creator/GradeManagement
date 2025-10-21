@forelse($students as $student)
<tr>
  <td>{{ $student->grade }}</td>
  <td>{{ $student->name }}</td>
  <td><a href="{{ route('students.show', $student->id) }}">詳細</a></td>
</tr>
@empty
<tr><td colspan="3">該当する学生が見つかりません</td></tr>
@endforelse