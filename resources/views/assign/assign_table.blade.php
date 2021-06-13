<table class="table table-bordered table-striped" id = "table_data">
    <thead>
        <tr>
            <th></th>
            <th>Mã lớp học phần</th>
            <th>Tên lớp học phần</th>
            <th>Số sinh viên</th>
            <th>Kì học</th>
        </tr>
    </thead>
    <tbody id = "tbody">
        @foreach($schedules as $sch)
          
        <tr>
            <th>
                <input type ="checkbox"  name = 
                    <?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?> value = 
                    <?php $a = str_replace(' ', '/', $sch->ID_Module_Class); echo $a; ?>>
                </th>
                <td>{{$sch->ID_Module_Class}}</td>
                <td>{{$sch->Module_Class_Name}}</td>
                <td>{{$sch->Number_Reality}}</td>
                <td>{{$sch->School_Year}}</td>
            </tr>
        @endforeach
      
        </tbody>
    </table>
</form>
<nav aria-label = "Page navigation example" id="pagination">
    {{ $schedules->links() }}
</nav> 

