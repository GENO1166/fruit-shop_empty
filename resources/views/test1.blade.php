<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Test1</h1>

    <label class="form-label">กรอกข้อมูล</label>
    <form action="{{ route('test2') }}" method="GET">
        <label>ชื่อสินค้า</label>
        <input type="text" name="name">

        <label>ราคา</label>
        <input type="text" name="price">

        <label>รายละเอียด</label>
        <input type="text" name="detail">

        <button type="submit">ส่งค่า</button>
    </form>


</body>

</html>
