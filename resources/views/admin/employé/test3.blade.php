

 @foreach ($viewData["employés"] as $employé)
 <!--@ foreach ($employees as $employee)-->

    <tr>
        <td>{{ $employé->name }}</td>
        <td>{{ $employé->date_naissance }}</td>
        <td>{{ $employé->affectations->Date_debut }}</td>
        <td>{{ $employé->affectations->Date_fin }}</td>
    </tr>
@endforeach
