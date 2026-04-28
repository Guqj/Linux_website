<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>学生成绩</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-box {
            display: flex;
            gap: 10px;
        }
        .search-box input {
            padding: 10px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            width: 250px;
            transition: border-color 0.3s;
        }
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
        }
        .search-box button {
            padding: 10px 20px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-box button:hover {
            background: #5a6fd6;
        }
        .btn-add {
            padding: 10px 25px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.3s;
        }
        .btn-add:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #667eea;
            color: white;
        }
        tr:hover {
            background: #f5f5f5;
        }
        .score {
            font-weight: bold;
            color: #667eea;
        }
        .action-btns {
            display: flex;
            gap: 8px;
        }
        .btn-edit {
            padding: 6px 12px;
            background: #ffc107;
            color: #333;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s;
        }
        .btn-edit:hover {
            background: #e0a800;
        }
        .btn-delete {
            padding: 6px 12px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s;
        }
        .btn-delete:hover {
            background: #c82333;
        }
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin-top: 25px;
            flex-wrap: wrap;
        }
        .pagination a, .pagination span {
            padding: 8px 14px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s;
        }
        .pagination a:hover {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        .pagination .active {
            background: #667eea;
            color: white;
            border-color: #667eea;
        }
        .pagination .disabled {
            color: #aaa;
            cursor: not-allowed;
            background: #f5f5f5;
        }
        .pagination .ellipsis {
            border: none;
            padding: 8px 5px;
        }
        .record-count {
            text-align: center;
            color: #666;
            margin-top: 15px;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal.show {
            display: flex;
        }
        .modal-content {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 400px;
            max-width: 90%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .modal-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        .form-group input:read-only {
            background: #f5f5f5;
            cursor: not-allowed;
        }
        .modal-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }
        .btn-confirm {
            padding: 10px 25px;
            background: #667eea;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-confirm:hover:not(:disabled) {
            background: #5a6fd6;
        }
        .btn-confirm:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .btn-cancel {
            padding: 10px 25px;
            background: #6c757d;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-cancel:hover {
            background: #5a6268;
        }
        .btn-danger {
            background: #dc3545;
        }
        .btn-danger:hover:not(:disabled) {
            background: #c82333;
        }
        .confirm-text {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        /* Alert styles */
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            border-radius: 8px;
            color: white;
            z-index: 2000;
            animation: slideIn 0.3s ease;
        }
        .alert-success {
            background: #28a745;
        }
        .alert-error {
            background: #dc3545;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📊 qjgu's学生成绩表</h1>

        <!-- 搜索框 -->
        <div class="header-row">
            <div class="search-box">
                <form action="{{ url('/scores') }}" method="GET" style="display: flex; gap: 10px;">
                    <input type="text" name="keyword" placeholder="输入姓名搜索..." value="{{ $keyword ?? '' }}">
                    <button type="submit">搜索</button>
                    @if(!empty($keyword))
                        <a href="{{ url('/scores') }}" style="padding: 10px 15px; background: #6c757d; color: white; border-radius: 8px; text-decoration: none;">清除</a>
                    @endif
                </form>
            </div>
            <button class="btn-add" onclick="openAddModal()">+ 添加</button>
        </div>

        <!-- 成绩表格 -->
        <table>
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>成绩</th>
                    <th style="width: 150px;">操作</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                @forelse($students as $student)
                    <tr data-id="{{ $student->id }}">
                        <td>{{ $student->name }}</td>
                        <td class="score">{{ $student->score }}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn-edit" onclick="openEditModal({{ $student->id }}, '{{ $student->name }}', {{ $student->score }})">编辑</button>
                                <button class="btn-delete" onclick="openDeleteModal({{ $student->id }}, '{{ $student->name }}')">删除</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #999; padding: 40px;">
                            暂无数据
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- 分页 -->
        @if($students->hasPages())
            <div class="pagination">
                @if($students->onFirstPage())
                    <span class="disabled">上一页</span>
                @else
                    <a href="{{ $students->previousPageUrl() }}">上一页</a>
                @endif

                {{-- 页码显示逻辑 --}}
                @php
                    $currentPage = $students->currentPage();
                    $lastPage = $students->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                @if($startPage > 1)
                    <a href="{{ $students->url(1) }}">1</a>
                    @if($startPage > 2)
                        <span class="ellipsis">...</span>
                    @endif
                @endif

                @for($i = $startPage; $i <= $endPage; $i++)
                    @if($i == $currentPage)
                        <span class="active">{{ $i }}</span>
                    @else
                        <a href="{{ $students->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor

                @if($endPage < $lastPage)
                    @if($endPage < $lastPage - 1)
                        <span class="ellipsis">...</span>
                    @endif
                    <a href="{{ $students->url($lastPage) }}">{{ $lastPage }}</a>
                @endif

                @if($students->hasMorePages())
                    <a href="{{ $students->nextPageUrl() }}">下一页</a>
                @else
                    <span class="disabled">下一页</span>
                @endif
            </div>
        @endif

        <p class="record-count">
            共 {{ $students->total() }} 条记录，当前第 {{ $students->currentPage() }} 页
        </p>
    </div>

    <!-- 添加 Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <h3 class="modal-title">添加学生成绩</h3>
            <form id="addForm">
                <div class="form-group">
                    <label for="addName">姓名</label>
                    <input type="text" id="addName" name="name" placeholder="请输入姓名" required>
                </div>
                <div class="form-group">
                    <label for="addScore">成绩</label>
                    <input type="number" id="addScore" name="score" placeholder="请输入成绩" min="0" max="100" step="0.1" required>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeAddModal()">取消</button>
                    <button type="submit" class="btn-confirm" id="addSubmitBtn" disabled>确定</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 编辑 Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <h3 class="modal-title">编辑学生成绩</h3>
            <form id="editForm">
                <input type="hidden" id="editId" name="id">
                <div class="form-group">
                    <label for="editName">姓名</label>
                    <input type="text" id="editName" name="name" readonly>
                </div>
                <div class="form-group">
                    <label for="editScore">成绩</label>
                    <input type="number" id="editScore" name="score" placeholder="请输入成绩" min="0" max="100" step="0.1" required>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeEditModal()">取消</button>
                    <button type="submit" class="btn-confirm" id="editSubmitBtn">确定</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 删除确认 Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <h3 class="modal-title">确认删除</h3>
            <p class="confirm-text">确定要删除学生 "<span id="deleteName"></span>" 的成绩记录吗？</p>
            <input type="hidden" id="deleteId">
            <div class="modal-buttons">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">取消</button>
                <button type="button" class="btn-confirm btn-danger" onclick="confirmDelete()">确定删除</button>
            </div>
        </div>
    </div>

    <script>
        // CSRF Token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // 显示提示信息
        function showAlert(message, type = 'success') {
            const alert = document.createElement('div');
            alert.className = `alert alert-${type}`;
            alert.textContent = message;
            document.body.appendChild(alert);
            setTimeout(() => alert.remove(), 3000);
        }

        // 添加 Modal
        const addModal = document.getElementById('addModal');
        const addForm = document.getElementById('addForm');
        const addName = document.getElementById('addName');
        const addScore = document.getElementById('addScore');
        const addSubmitBtn = document.getElementById('addSubmitBtn');

        function openAddModal() {
            addModal.classList.add('show');
            addForm.reset();
            addSubmitBtn.disabled = true;
            setTimeout(() => addName.focus(), 100);
        }

        function closeAddModal() {
            addModal.classList.remove('show');
            addForm.reset();
            addSubmitBtn.disabled = true;
        }

        function validateAddForm() {
            addSubmitBtn.disabled = !(addName.value.trim() && addScore.value !== '');
        }

        addName.addEventListener('input', validateAddForm);
        addScore.addEventListener('input', validateAddForm);

        addForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (addSubmitBtn.disabled) return;

            try {
                const response = await fetch('{{ url("/students") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        name: addName.value.trim(),
                        score: parseFloat(addScore.value)
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showAlert('添加成功！');
                    closeAddModal();
                    location.reload();
                } else {
                    showAlert(data.message || '添加失败', 'error');
                }
            } catch (error) {
                showAlert('网络错误，请重试', 'error');
            }
        });

        // 编辑 Modal
        const editModal = document.getElementById('editModal');
        const editForm = document.getElementById('editForm');
        const editId = document.getElementById('editId');
        const editName = document.getElementById('editName');
        const editScore = document.getElementById('editScore');
        const editSubmitBtn = document.getElementById('editSubmitBtn');

        function openEditModal(id, name, score) {
            editId.value = id;
            editName.value = name;
            editScore.value = score;
            editModal.classList.add('show');
            setTimeout(() => editScore.focus(), 100);
        }

        function closeEditModal() {
            editModal.classList.remove('show');
            editForm.reset();
        }

        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            try {
                const response = await fetch(`{{ url("/students") }}/${editId.value}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        score: parseFloat(editScore.value)
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showAlert('更新成功！');
                    closeEditModal();
                    location.reload();
                } else {
                    showAlert(data.message || '更新失败', 'error');
                }
            } catch (error) {
                showAlert('网络错误，请重试', 'error');
            }
        });

        // 删除 Modal
        const deleteModal = document.getElementById('deleteModal');
        const deleteId = document.getElementById('deleteId');
        const deleteName = document.getElementById('deleteName');

        function openDeleteModal(id, name) {
            deleteId.value = id;
            deleteName.textContent = name;
            deleteModal.classList.add('show');
        }

        function closeDeleteModal() {
            deleteModal.classList.remove('show');
        }

        async function confirmDelete() {
            try {
                const response = await fetch(`{{ url("/students") }}/${deleteId.value}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showAlert('删除成功！');
                    closeDeleteModal();
                    location.reload();
                } else {
                    showAlert(data.message || '删除失败', 'error');
                }
            } catch (error) {
                showAlert('网络错误，请重试', 'error');
            }
        }

        // 点击 Modal 外部关闭
        [addModal, editModal, deleteModal].forEach(modal => {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.remove('show');
                }
            });
        });

        // 保持搜索参数的分页链接
        document.querySelectorAll('.pagination a').forEach(link => {
            const keyword = '{{ $keyword ?? "" }}';
            if (keyword) {
                const url = new URL(link.href);
                url.searchParams.set('keyword', keyword);
                link.href = url.toString();
            }
        });
    </script>
</body>
</html>
