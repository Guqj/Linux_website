# 学生成绩管理系统

一个基于 Laravel 框架的学生成绩管理系统，用于管理学生信息和成绩数据。

## 功能特性

- **学生信息管理**：添加、编辑、删除学生信息
- **成绩录入**：为每个学生记录成绩
- **搜索功能**：按学生姓名搜索
- **分页显示**：每页显示8条记录
- **RESTful API**：支持标准的CRUD操作

## 技术栈

- **后端框架**：Laravel 10.10
- **前端构建工具**：Vite
- **数据库**：MySQL（默认）
- **PHP版本**：8.1+

## 安装步骤

### 1. 克隆项目

```bash
git clone <项目仓库地址>
cd student-scores
```

### 2. 安装依赖

```bash
composer install
npm install
```

### 3. 环境配置

复制环境文件：

```bash
cp .env.example .env
```

编辑 `.env` 文件，配置数据库连接信息：

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=student_scores
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. 生成应用密钥

```bash
php artisan key:generate
```

### 5. 迁移数据库

```bash
php artisan migrate
```

### 6. 启动开发服务器

```bash
php artisan serve
```

### 7. 构建前端资源

```bash
npm run dev
```

## 使用说明

### 访问应用

打开浏览器访问：http://localhost:8000

### 主要功能

- **首页**：显示学生列表，支持搜索和分页
- **添加学生**：通过表单添加新的学生信息
- **编辑成绩**：点击学生记录可编辑成绩
- **删除学生**：删除不需要的学生记录

### API 接口

- `GET /students` - 获取学生列表（支持搜索和分页）
- `POST /students` - 添加新学生
- `PUT /students/{id}` - 更新学生成绩
- `DELETE /students/{id}` - 删除学生

## 项目结构

```
app/
├── Http/
│   └── Controllers/
│       └── ScoreController.php  # 主要控制器
└── Models/
    └── Scorename.php           # 学生成绩模型
```

## 路由说明

- `/` - 首页
- `/students` - 学生列表
- `/scores` - 成绩列表（别名）
- `/students/{id}` - 特定学生操作

## 开发

### 运行测试

```bash
php artisan test
```

### 代码规范

使用 Laravel Pint 进行代码格式化：

```bash
./vendor/bin/pint
```

## 许可证

本项目基于 MIT 许可证开源。

## 贡献

欢迎提交 Issue 和 Pull Request。

## 联系方式

如有问题，请通过以下方式联系：
- 邮箱：[你的邮箱]
- GitHub：[你的GitHub地址]