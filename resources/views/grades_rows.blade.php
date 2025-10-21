@forelse($grades as $g)
<tr>
  <td>{{ $g->grade }}</td>
  <td>{{ $g->term }}</td>
  <td>{{ $g->japanese }}</td>
  <td>{{ $g->math }}</td>
  <td>{{ $g->science }}</td>
  <td>{{ $g->social_studies }}</td>
  <td>{{ $g->music }}</td>
  <td>{{ $g->home_economics }}</td>
  <td>{{ $g->english }}</td>
  <td>{{ $g->art }}</td>
  <td>{{ $g->health_and_physical_education }}</td>
  <td><a href="{{ route('grades.edit', $g->id) }}">編集</a></td>
</tr>
@empty
<tr><td colspan="12">該当する成績が見つかりません</td></tr>
@endforelse