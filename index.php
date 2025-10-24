<?php
// 模拟数据，替代数据库查询
$userSchoolName = "示例学校";
$userSchoolYear = "2024";
$userSchoolCode = "SCH001";
$userLanguage = "zh";

// 模拟班级数据
$userClassListNew = ["P1A", "P1B", "P2A", "P2B", "P3A", "P3B", "P4A", "P4B", "P5A", "P5B", "P6A", "P6B"];

// 模拟学生数据
$mockStudents = [
    "P1A" => [
        ["id" => "S001", "name" => "张三", "number" => "01", "class" => "P1A"],
        ["id" => "S002", "name" => "李四", "number" => "02", "class" => "P1A"],
        ["id" => "S003", "name" => "王五", "number" => "03", "class" => "P1A"],
        ["id" => "S004", "name" => "赵六", "number" => "04", "class" => "P1A"],
        ["id" => "S005", "name" => "钱七", "number" => "05", "class" => "P1A"]
    ],
    "P1B" => [
        ["id" => "S006", "name" => "孙八", "number" => "01", "class" => "P1B"],
        ["id" => "S007", "name" => "周九", "number" => "02", "class" => "P1B"],
        ["id" => "S008", "name" => "吴十", "number" => "03", "class" => "P1B"],
        ["id" => "S009", "name" => "郑十一", "number" => "04", "class" => "P1B"],
        ["id" => "S010", "name" => "王十二", "number" => "05", "class" => "P1B"]
    ]
];

// 获取选中的班级
$selectClass = isset($_GET['class']) && in_array($_GET['class'], $userClassListNew) ? $_GET['class'] : $userClassListNew[0];

// 生成token
$token = bin2hex(random_bytes(16));

// 判断是否小学
$firstChar = substr($userClassListNew[0], 0, 1);
$isPrimary = ($firstChar == 'P') ? 'true' : 'notTrue';
?>
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>智能跳繩計數系統 - 多設備版</title>
<input type="hidden" id="token" value="<?php echo $token; ?>">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Microsoft YaHei', Arial, sans-serif;
    min-height: 100vh;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.container1 {
    max-width: 98%;
    margin: 0 auto;
    padding: 0 10px;
}

h1 {
    text-align: center;
    color: #2C3E50;
    margin-bottom: 30px;
    font-size: 2.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
}

/* 控制面板样式 */
.controls-panel {
    background: white;
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border: 1px solid #e0e0e0;
}

.controls-title {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-size: 1.5rem;
    font-weight: bold;
    color: #2C3E50;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.controls-content {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    align-items: center;
}

.control-group {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 15px;
    background: #f8f9fa;
    border-radius: 10px;
    border: 1px solid #e9ecef;
}

.control-label {
    font-weight: 600;
    color: #495057;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

.control-select {
    padding: 8px 12px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    background: white;
    font-size: 14px;
    min-width: 120px;
}

.control-divider {
    width: 1px;
    height: 40px;
    background: #dee2e6;
    margin: 0 10px;
}

.timer-group {
    flex-direction: column;
    gap: 15px;
    padding: 15px 20px;
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
}

.timer-value {
    font-size: 2rem;
    font-weight: bold;
    color: #1976d2;
    text-align: center;
    padding: 10px 20px;
    background: white;
    border-radius: 10px;
    border: 2px solid #2196f3;
    min-width: 120px;
}

.timer-edit-group {
    flex-direction: column;
    gap: 15px;
    padding: 15px 20px;
    background: linear-gradient(135deg, #fff3e0 0%, #fce4ec 100%);
}

.time-input-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.time-input {
    width: 60px;
    padding: 8px;
    border: 1px solid #ced4da;
    border-radius: 6px;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
}

.time-label {
    font-weight: 600;
    color: #495057;
}

.control-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 25px;
    font-size: 15px;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.15);
}

.btn:active {
    transform: translateY(0);
}

.btn-primary {
    background: #2196F3;
    color: white;
}

.btn-primary:hover {
    background: #1976D2;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.btn-action {
    padding: 15px 30px;
    font-size: 16px;
    font-weight: bold;
}

.btn-start {
    background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    color: white;
}

.btn-start:hover {
    background: linear-gradient(135deg, #45a049 0%, #3d8b40 100%);
}

.btn-stop {
    background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
    color: white;
}

.btn-stop:hover {
    background: linear-gradient(135deg, #d32f2f 0%, #c62828 100%);
}

.btn-scores {
    background: linear-gradient(135deg, #9C27B0 0%, #7B1FA2 100%);
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-scores:hover {
    background: linear-gradient(135deg, #7B1FA2 0%, #6a1b9a 100%);
    color: white;
    text-decoration: none;
}

.btn-sm {
    padding: 8px 16px;
    font-size: 14px;
}

/* 排名列表样式 */
.summary-list {
    background: white;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border: 1px solid #e0e0e0;
}

.ranking-header {
    text-align: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.ranking-timer {
    font-size: 2rem;
    font-weight: bold;
    color: #1976d2;
    padding: 10px 20px;
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
    border-radius: 10px;
    display: inline-block;
}

/* 跳繩網格樣式 */
.rope-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.rope-card {
    background: white;
    border-radius: 12px;
    padding: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    position: relative;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.rope-card.connected {
    background: linear-gradient(135deg, #e8f5e9 0%, #f1f8e9 100%);
    border: 2px solid #4CAF50;
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.25);
}

.rope-card.connected::before {
    content: '';
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    background: linear-gradient(45deg, #4CAF50, #8BC34A, #4CAF50);
    border-radius: 12px;
    opacity: 0;
    z-index: -1;
    animation: pulseGlow 2s infinite;
}

.rope-card.active {
    background: linear-gradient(135deg, #e3f2fd 0%, #e1f5fe 100%);
    border: 2px solid #2196F3;
    box-shadow: 0 6px 20px rgba(33, 150, 243, 0.3);
    animation: activeAnimation 1s infinite alternate;
}

.rope-card.empty {
    background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
    border: 2px dashed #bdbdbd;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    opacity: 0.9;
}

@keyframes pulseGlow {
    0%, 100% { opacity: 0; }
    50% { opacity: 0.3; }
}

@keyframes activeAnimation {
    0% { transform: scale(1); }
    100% { transform: scale(1.02); }
}

.rope-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
}

.rope-name {
    font-weight: bold;
    font-size: 1.1rem;
    color: #333;
}

.rope-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.status-empty {
    background: #f5f5f5;
    color: #666;
}

.status-connected {
    background: #e8f5e9;
    color: #2e7d32;
}

.status-active {
    background: #e3f2fd;
    color: #1565c0;
}

.rope-data {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 15px;
}

.data-item {
    text-align: center;
    padding: 10px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.data-label {
    font-size: 0.85rem;
    color: #666;
    margin-bottom: 5px;
}

.data-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #333;
}

.battery-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    margin-bottom: 10px;
}

.battery-icon {
    font-size: 1.2rem;
}

.battery-low { color: #f44336; }
.battery-medium { color: #ff9800; }
.battery-high { color: #4caf50; }

.student-selection {
    margin: 10px 0;
    padding: 10px;
    background: #f9f9f9;
    border-radius: 8px;
}

.class-selector, .student-selector {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 14px;
    margin-bottom: 10px;
}

.empty-slot {
    text-align: center;
    padding: 20px;
}

.btn-add {
    background: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-add:hover {
    background: #45a049;
    transform: translateY(-2px);
}

.btn-add:disabled {
    background: #cccccc;
    cursor: not-allowed;
    transform: none;
}

/* 警告对话框样式 */
.custom-alert-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: none;
}

.custom-alert {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    z-index: 1001;
    text-align: center;
    max-width: 400px;
    width: 90%;
    display: none;
}

.custom-alert h3 {
    color: #f44336;
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.custom-alert p {
    color: #666;
    margin-bottom: 20px;
    line-height: 1.5;
}

.alert-button {
    padding: 10px 25px;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
}

.alert-button.cancel {
    background: #6c757d;
    color: white;
}

.alert-button.cancel:hover {
    background: #5a6268;
}

/* 响应式设计 */
@media (max-width: 768px) {
    .controls-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .control-group {
        justify-content: center;
    }
    
    .control-divider {
        display: none;
    }
    
    .rope-grid {
        grid-template-columns: 1fr;
    }
    
    .rope-data {
        grid-template-columns: 1fr;
    }
}
</style>
</head>
<body>
    <div class="container1">
        <br>
        <!-- 控制面板 -->
        <div class="controls-panel">
            <div class="controls-title">
                <i class="fas fa-running"></i>
                <span>跳繩比賽</span>
            </div>
            
            <div class="controls-content">
                <!-- 班級選擇器 -->
                <div class="control-group">
                    <label for="classSelector" class="control-label">
                        <i class="fas fa-users"></i> 班級
                    </label>
                    <select id="classSelector" class="control-select" onchange="reloadWithNewClass(this.value)">
                        <?php
                        for ($i=0; $i<count($userClassListNew); $i++) {
                            if($userClassListNew[$i] != ''){
                                $selected = ($selectClass === $userClassListNew[$i]) ? 'selected' : '';
                                echo "<option value='{$userClassListNew[$i]}' {$selected}>{$userClassListNew[$i]}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                
                <!-- 分隔線 -->
                <div class="control-divider"></div>
                
                <!-- 时间显示部分 -->
                <div class="control-group timer-group" id="timerDisplay">
                    <label class="control-label">
                        <i class="fas fa-clock"></i> 計時
                    </label>
                    <div class="timer-value" id="timerDisplayValue">01:00</div>
                    <button class="btn-secondary btn-sm" onclick="enableTimerEdit()">
                        <i class="fas fa-edit"></i> 修改
                    </button>
                </div>
                
                <!-- 时间编辑部分 -->
                <div class="control-group timer-edit-group" id="timerEdit" style="display: none;">
                    <div class="time-input-wrapper">
                        <input type="number" id="minutesInput" min="0" max="60" value="1" class="time-input">
                        <span class="time-label">分</span>
                    </div>
                    <div class="time-input-wrapper">
                        <input type="number" id="secondsInput" min="0" max="59" value="0" class="time-input">
                        <span class="time-label">秒</span>
                    </div>
                    <button class="btn-primary btn-sm" onclick="setTimer()">
                        <i class="fas fa-check"></i> 確認
                    </button>
                </div>
                
                <!-- 分隔線 -->
                <div class="control-divider"></div>
                
                <!-- 控制按鈕組 -->
                <div class="control-actions">
                    <button class="btn-action btn-start" onclick="startAllRopesWithTimer()">
                        <i class="fas fa-play-circle"></i>
                        <span>開始比賽</span>
                    </button>
                    <button class="btn-action btn-stop" onclick="stopAllRopes()">
                        <i class="fas fa-stop-circle"></i>
                        <span>停止比賽</span>
                    </button>
                </div>
                
                <!-- 分隔線 -->
                <div class="control-divider"></div>
                
                <!-- 成績查看按鈕 -->
                <button class="btn-action btn-scores" onclick="showScores()">
                    <i class="fas fa-chart-line"></i>
                    <span>查看成績</span>
                </button>
            </div>
        </div>

        <!-- 排名列表 -->
        <div class="summary-list" id="rankingList" style="display:none">
            <div class="ranking-header">
                <div class="ranking-timer" id="rankingTimer">00:00</div>
            </div>
            <div id="rankingContent"></div>
        </div>
        
        <!-- 跳繩網格 -->
        <div class="rope-grid" id="ropeGrid">
            <!-- 動態生成跳繩卡片 -->
        </div>
    </div>

    <!-- 自定義警告對話框 -->
    <div class="custom-alert-overlay" id="customAlertOverlay"></div>
    <div class="custom-alert" id="customAlert">
        <h3>⚠️ 比賽進行中</h3>
        <p>比賽正在進行中，無法查看成績。<br>請先停止比賽後再查看成績。</p>
        <button class="alert-button cancel" onclick="closeCustomAlert()">確定</button>
    </div>

    <script>
    // 全局變量
    let ropeDevices = {};  // 存儲所有跳繩設備
    let maxDevices = 8;    // 最多連接8個設備
    let pollingInterval = null;
    let dataUpdateInterval = null;
    let scanningInProgress = false;  // 掃描進行中標記

    // 全局計時器變量
    let globalTimerActive = false;
    let globalTimerInterval = null;
    let globalCountdownTime = 60; // 默认1分钟
    let currentCountdownTime = 60;
    let timerConfirmed = true;

    let batchScanActive = false;
    let heartbeatIntervals = {};  // 存儲每個設備的心跳定時器

    // 藍牙服務和特徵 UUID
    const SERVICE_UUID = "00005301-0000-0041-4c50-574953450000";
    const WRITE_UUID = "00005302-0000-0041-4c50-574953450000";
    const NOTIFY_UUID = "00005303-0000-0041-4c50-574953450000";

    // 從PHP獲取全局變量
    const schoolCode = "<?php echo $userSchoolCode; ?>";
    const schoolYear = "<?php echo $userSchoolYear; ?>";
    const isPrimary = <?php echo $isPrimary; ?>;
    const selectedClass = "<?php echo $selectClass; ?>";
    
    // 模擬學生數據
    const mockStudents = <?php echo json_encode($mockStudents); ?>;

    // 獲取默認設備名稱
    function getDefaultDeviceName(index) {
        const deviceNumber = index.toString().padStart(3, '0');
        return 'JR_A' + deviceNumber;
    }

    // 生成訪客名稱
    function generateGuestName(index) {
        return '訪客' + index;
    }

    // 初始化設備槽位
    function initializeDevices() {
        for (let i = 1; i <= maxDevices; i++) {
            ropeDevices[`跳繩${i}`] = {
                id: `跳繩${i}`,
                count: 0,
                time: 0,
                status: "空閒",
                battery: 0,
                mode: 0,
                device: null,
                deviceName: "",
                deviceId: "",
                writeChar: null,
                notifyChar: null,
                isActive: false,
                selectedStudent: null,
                selectedStudentName: "",
                selectedClass: null,
                studentList: []
            };
        }
        updateRopeGrid();
    }

    // 更新跳繩網格
    function updateRopeGrid() {
        const grid = document.getElementById('ropeGrid');
        grid.innerHTML = '';
        
        for (let i = 1; i <= maxDevices; i++) {
            const ropeId = `跳繩${i}`;
            const rope = ropeDevices[ropeId];
            const card = document.createElement('div');
            
            if (rope.status === "空閒") {
                // 空閒狀態的卡片
                card.className = 'rope-card empty';
                
                if (rope.selectedStudent) {
                    // 已選擇學生
                    card.innerHTML = 
                        '<div class="rope-header">' +
                            '<div class="rope-name">' + getDefaultDeviceName(i) + '</div>' +
                            '<div class="rope-status status-empty">未連接</div>' +
                        '</div>' +
                        
                        '<div class="student-selection" style="margin: 10px 0; padding: 10px; background: #f9f9f9; border-radius: 8px;">' +
                            '<div style="font-size: 0.95rem; color: #333; display: flex; justify-content: space-between; align-items: center;">' +
                                '<span><strong>學生:</strong> ' + (rope.selectedStudentName || '') + '</span>' +
                                '<button onclick="resetStudent(\'' + ropeId + '\')" ' +
                                'style="background: #f0f0f0; border: none; border-radius: 15px; padding: 6px 12px; ' +
                                'font-size: 13px; cursor: pointer; color: #666; transition: all 0.3s ease;">' +
                                '重選學生</button>' +
                            '</div>' +
                        '</div>' +
                        
                        '<div class="empty-slot">' +
                            '<button type="button" class="btn btn-add" onclick="connectToSlot(\'' + ropeId + '\')">' +
                                '連接設備' +
                            '</button>' +
                        '</div>';
                } else {
                    // 未選擇學生，顯示選擇器
                    const availableClasses = Object.keys(mockStudents);
                    let classOptions = '<option value="">選擇班級</option>';
                    availableClasses.forEach(cls => {
                        const selected = rope.selectedClass === cls ? 'selected' : '';
                        classOptions += '<option value="' + cls + '" ' + selected + '>' + cls + '</option>';
                    });
                    
                    let studentOptions = '<option value="">選擇學生</option>';
                    studentOptions += '<option value="' + ropeId + '">訪客-' + ropeId + '</option>';
                    if (rope.studentList && rope.studentList.length > 0) {
                        rope.studentList.forEach(student => {
                            const selected = rope.selectedStudent === student.id ? 'selected' : '';
                            const displayName = student.class + ': ' + (student.number || '') + ' ' + student.name;
                            studentOptions += '<option value="' + student.id + '" ' + selected + '>' + displayName + '</option>';
                        });
                    }
                    
                    card.innerHTML = 
                        '<div class="rope-header">' +
                            '<div class="rope-name">' + getDefaultDeviceName(i) + '</div>' +
                            '<div class="rope-status status-empty">未連接</div>' +
                        '</div>' +
                        
                        '<div class="student-selection" style="margin: 10px 0; padding: 10px; background: #f9f9f9; border-radius: 8px;">' +
                            '<div style="display: flex; gap: 10px; align-items: center;">' +
                                '<select class="class-selector" style="width: 40%; padding: 5px; border-radius: 4px; border: 1px solid #ddd;" ' +
                                        'onchange="onClassChange(\'' + ropeId + '\', this.value)">' +
                                    classOptions +
                                '</select>' +
                                '<select class="student-selector" id="student-' + ropeId + '" ' +
                                        'style="width: 60%; padding: 5px; border-radius: 4px; border: 1px solid #ddd;"' +
                                        'onchange="onStudentChange(\'' + ropeId + '\', this.value)">' +
                                    studentOptions +
                                '</select>' +
                            '</div>' +
                        '</div>' +
                        
                        '<div class="empty-slot">' +
                            '<button type="button" class="btn btn-add" onclick="connectToSlot(\'' + ropeId + '\')">' +
                                '連接設備' +
                            '</button>' +
                        '</div>';
                }
            } else {
                // 已连接的卡片
                let cardClass = 'rope-card';
                if (rope.status === '已連接') cardClass += ' connected';
                if (rope.isActive) cardClass += ' active';
                
                card.className = cardClass;
                
                let batteryClass = '';
                if (rope.battery < 20) batteryClass = 'low';
                else if (rope.battery < 50) batteryClass = 'medium';
                
                let statusClass = 'status-disconnected';
                if (rope.status === '已連接') statusClass = 'status-connected';
                if (rope.isActive) statusClass = 'status-active';
                
                const modeText = ['自由跳', '倒计数', '倒计时'][rope.mode] || '未知';
                
                if (rope.selectedStudent) {
                    // 已選擇學生
                    card.innerHTML = 
                        '<div class="rope-header">' +
                            '<div class="rope-name">' + ropeId + '</div>' +
                            '<div class="rope-status ' + statusClass + '">' +
                                (rope.isActive ? '跳繩中' : rope.status) +
                            '</div>' +
                        '</div>' +
                        
                        '<div class="student-selection" style="margin: 10px 0; padding: 10px; background: #f9f9f9; border-radius: 8px;">' +
                            '<div style="font-size: 0.95rem; color: #333; display: flex; justify-content: space-between; align-items: center;">' +
                                '<span><strong>學生:</strong> ' + (rope.selectedStudentName || '') + '</span>' +
                                '<button onclick="resetStudent(\'' + ropeId + '\')" ' +
                                (rope.isActive ? 'disabled ' : '') +
                                'style="background: #f0f0f0; border: none; border-radius: 15px; padding: 6px 12px; ' +
                                'font-size: 13px; cursor: pointer; color: #666; transition: all 0.3s ease;">' +
                                '重選學生</button>' +
                            '</div>' +
                        '</div>' +
                        
                        '<div class="rope-data">' +
                            '<div class="data-item">' +
                                '<div class="data-label">次數</div>' +
                                '<div class="data-value">' + rope.count + '</div>' +
                            '</div>' +
                            '<div class="data-item">' +
                                '<div class="data-label">時間</div>' +
                                '<div class="data-value">' + formatTime(rope.time) + '</div>' +
                            '</div>' +
                        '</div>' +
                        
                        '<div class="battery-info">' +
                            '<i class="fas fa-battery-' + (rope.battery < 20 ? 'quarter' : rope.battery < 50 ? 'half' : 'full') + ' battery-' + batteryClass + '"></i>' +
                            '<span class="battery-' + batteryClass + '">' + rope.battery + '%</span>' +
                        '</div>' +
                        
                        '<div style="text-align: center; margin-top: 10px;">' +
                            '<button class="btn btn-disconnect" onclick="disconnectRope(\'' + ropeId + '\')">' +
                                '斷開連接' +
                            '</button>' +
                        '</div>';
                } else {
                    // 未選擇學生
                    const availableClasses = Object.keys(mockStudents);
                    let classOptions = '<option value="">選擇班級</option>';
                    availableClasses.forEach(cls => {
                        const selected = rope.selectedClass === cls ? 'selected' : '';
                        classOptions += '<option value="' + cls + '" ' + selected + '>' + cls + '</option>';
                    });
                    
                    let studentOptions = '<option value="">選擇學生</option>';
                    studentOptions += '<option value="' + ropeId + '">訪客-' + ropeId + '</option>';
                    if (rope.studentList && rope.studentList.length > 0) {
                        rope.studentList.forEach(student => {
                            const selected = rope.selectedStudent === student.id ? 'selected' : '';
                            const displayName = student.class + ': ' + (student.number || '') + ' ' + student.name;
                            studentOptions += '<option value="' + student.id + '" ' + selected + '>' + displayName + '</option>';
                        });
                    }
                    
                    card.innerHTML = 
                        '<div class="rope-header">' +
                            '<div class="rope-name">' + ropeId + '</div>' +
                            '<div class="rope-status ' + statusClass + '">' +
                                (rope.isActive ? '跳繩中' : rope.status) +
                            '</div>' +
                        '</div>' +
                        
                        '<div class="student-selection" style="margin: 10px 0; padding: 10px; background: #f9f9f9; border-radius: 8px;">' +
                            '<div style="display: flex; gap: 10px; align-items: center;">' +
                                '<select class="class-selector" style="width: 40%; padding: 5px; border-radius: 4px; border: 1px solid #ddd;" ' +
                                        'onchange="onClassChange(\'' + ropeId + '\', this.value)">' +
                                    classOptions +
                                '</select>' +
                                '<select class="student-selector" id="student-' + ropeId + '" ' +
                                        'style="width: 60%; padding: 5px; border-radius: 4px; border: 1px solid #ddd;"' +
                                        'onchange="onStudentChange(\'' + ropeId + '\', this.value)">' +
                                    studentOptions +
                                '</select>' +
                            '</div>' +
                        '</div>' +
                        
                        '<div class="rope-data">' +
                            '<div class="data-item">' +
                                '<div class="data-label">次數</div>' +
                                '<div class="data-value">' + rope.count + '</div>' +
                            '</div>' +
                            '<div class="data-item">' +
                                '<div class="data-label">時間</div>' +
                                '<div class="data-value">' + formatTime(rope.time) + '</div>' +
                            '</div>' +
                        '</div>' +
                        
                        '<div class="battery-info">' +
                            '<i class="fas fa-battery-' + (rope.battery < 20 ? 'quarter' : rope.battery < 50 ? 'half' : 'full') + ' battery-' + batteryClass + '"></i>' +
                            '<span class="battery-' + batteryClass + '">' + rope.battery + '%</span>' +
                        '</div>' +
                        
                        '<div style="text-align: center; margin-top: 10px;">' +
                            '<button class="btn btn-disconnect" onclick="disconnectRope(\'' + ropeId + '\')">' +
                                '斷開連接' +
                            '</button>' +
                        '</div>';
                }
            }
            
            grid.appendChild(card);
        }
    }

    // 格式化時間
    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return mins.toString().padStart(2, '0') + ':' + secs.toString().padStart(2, '0');
    }

    // 班級變更處理
    function onClassChange(ropeId, classValue) {
        const rope = ropeDevices[ropeId];
        rope.selectedClass = classValue;
        rope.selectedStudent = null;
        rope.selectedStudentName = "";
        
        if (classValue && mockStudents[classValue]) {
            rope.studentList = mockStudents[classValue];
        } else {
            rope.studentList = [];
        }
        
        updateRopeGrid();
    }

    // 學生變更處理
    function onStudentChange(ropeId, studentValue) {
        const rope = ropeDevices[ropeId];
        
        if (studentValue === ropeId) {
            // 選擇訪客
            rope.selectedStudent = ropeId;
            rope.selectedStudentName = generateGuestName(ropeId);
        } else if (studentValue) {
            // 選擇真實學生
            const student = rope.studentList.find(s => s.id === studentValue);
            if (student) {
                rope.selectedStudent = student.id;
                rope.selectedStudentName = student.class + ': ' + (student.number || '') + ' ' + student.name;
            }
        } else {
            rope.selectedStudent = null;
            rope.selectedStudentName = "";
        }
        
        updateRopeGrid();
    }

    // 重置學生選擇
    function resetStudent(ropeId) {
        const rope = ropeDevices[ropeId];
        rope.selectedStudent = null;
        rope.selectedStudentName = "";
        updateRopeGrid();
    }

    // 連接到槽位
    function connectToSlot(ropeId) {
        if (scanningInProgress) {
            alert('掃描進行中，請稍候...');
            return;
        }
        
        if (!ropeDevices[ropeId].selectedStudent) {
            alert('請先選擇學生！');
            return;
        }
        
        startBluetoothScan(ropeId);
    }

    // 開始藍牙掃描
    async function startBluetoothScan(ropeId) {
        if (!navigator.bluetooth) {
            alert('此瀏覽器不支持藍牙功能');
            return;
        }
        
        scanningInProgress = true;
        
        try {
            const device = await navigator.bluetooth.requestDevice({
                filters: [
                    { namePrefix: 'JR_A' },
                    { namePrefix: 'JR_B' }
                ],
                optionalServices: [SERVICE_UUID]
            });
            
            await connectToDevice(device, ropeId);
        } catch (error) {
            console.error('藍牙掃描失敗:', error);
            if (error.name !== 'NotFoundError') {
                alert('藍牙掃描失敗: ' + error.message);
            }
        } finally {
            scanningInProgress = false;
        }
    }

    // 連接到設備
    async function connectToDevice(device, ropeId) {
        try {
            const rope = ropeDevices[ropeId];
            
            device.addEventListener('gattserverdisconnected', () => {
                handleDisconnect(ropeId);
            });
            
            const server = await device.gatt.connect();
            const service = await server.getPrimaryService(SERVICE_UUID);
            const writeChar = await service.getCharacteristic(WRITE_UUID);
            const notifyChar = await service.getCharacteristic(NOTIFY_UUID);
            
            await notifyChar.startNotifications();
            notifyChar.addEventListener('characteristicvaluechanged', (event) => {
                handleNotification(event, ropeId);
            });
            
            rope.device = device;
            rope.writeChar = writeChar;
            rope.notifyChar = notifyChar;
            rope.status = "已連接";
            rope.deviceName = device.name || getDefaultDeviceName(parseInt(ropeId.replace('跳繩', '')));
            rope.deviceId = device.id;
            rope.battery = Math.floor(Math.random() * 100) + 1; // 模擬電池電量
            
            // 開始心跳
            startHeartbeat(ropeId);
            
            updateRopeGrid();
            
        } catch (error) {
            console.error('連接失敗:', error);
            alert('連接失敗: ' + error.message);
        }
    }

    // 處理通知
    function handleNotification(event, ropeId) {
        const value = event.target.value;
        const data = new Uint8Array(value.buffer);
        
        // 這裡可以解析設備數據
        console.log(`${ropeId} 收到數據:`, data);
        
        // 模擬數據更新
        const rope = ropeDevices[ropeId];
        if (rope.isActive) {
            rope.count += Math.floor(Math.random() * 3) + 1;
            rope.time += 1;
        }
        
        updateRopeGrid();
    }

    // 開始心跳
    function startHeartbeat(ropeId) {
        if (heartbeatIntervals[ropeId]) {
            clearInterval(heartbeatIntervals[ropeId]);
        }
        
        heartbeatIntervals[ropeId] = setInterval(() => {
            sendHeartbeat(ropeId);
        }, 5000);
    }

    // 發送心跳
    async function sendHeartbeat(ropeId) {
        const rope = ropeDevices[ropeId];
        
        if (!rope.writeChar || !rope.device || !rope.device.gatt.connected) {
            if (heartbeatIntervals[ropeId]) {
                clearInterval(heartbeatIntervals[ropeId]);
                delete heartbeatIntervals[ropeId];
            }
            return;
        }
        
        try {
            // 模擬心跳命令
            const cmd = new Uint8Array([0x06, 0x01, 0xA5]);
            await rope.writeChar.writeValue(cmd);
            console.log(`${ropeId}: 心跳發送成功`);
        } catch (error) {
            console.error(`${ropeId}: 心跳發送失敗`, error);
            if (!rope.device.gatt.connected) {
                handleDisconnect(ropeId);
            }
        }
    }

    // 處理斷開連接
    function handleDisconnect(ropeId) {
        const rope = ropeDevices[ropeId];
        rope.device = null;
        rope.writeChar = null;
        rope.notifyChar = null;
        rope.status = "空閒";
        rope.isActive = false;
        rope.count = 0;
        rope.time = 0;
        
        if (heartbeatIntervals[ropeId]) {
            clearInterval(heartbeatIntervals[ropeId]);
            delete heartbeatIntervals[ropeId];
        }
        
        updateRopeGrid();
    }

    // 斷開連接
    function disconnectRope(ropeId) {
        const rope = ropeDevices[ropeId];
        if (rope.device && rope.device.gatt.connected) {
            rope.device.gatt.disconnect();
        }
        handleDisconnect(ropeId);
    }

    // 計時器相關功能
    function enableTimerEdit() {
        document.getElementById('timerDisplay').style.display = 'none';
        document.getElementById('timerEdit').style.display = 'flex';
    }

    function setTimer() {
        const minutes = parseInt(document.getElementById('minutesInput').value) || 0;
        const seconds = parseInt(document.getElementById('secondsInput').value) || 0;
        
        if (minutes < 0 || minutes > 60 || seconds < 0 || seconds > 59) {
            alert('請輸入有效的時間範圍！');
            return;
        }
        
        globalCountdownTime = minutes * 60 + seconds;
        currentCountdownTime = globalCountdownTime;
        
        updateTimerDisplay();
        
        document.getElementById('timerEdit').style.display = 'none';
        document.getElementById('timerDisplay').style.display = 'flex';
        
        timerConfirmed = true;
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(currentCountdownTime / 60);
        const seconds = currentCountdownTime % 60;
        document.getElementById('timerDisplayValue').textContent = 
            minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
    }

    // 開始所有跳繩
    function startAllRopesWithTimer() {
        if (!timerConfirmed) {
            alert('請先確認計時設置！');
            return;
        }
        
        const connectedRopes = Object.values(ropeDevices).filter(rope => rope.status === '已連接');
        if (connectedRopes.length === 0) {
            alert('沒有已連接的設備！');
            return;
        }
        
        // 開始全局計時器
        startGlobalTimer();
        
        // 開始所有已連接的跳繩
        connectedRopes.forEach(rope => {
            rope.isActive = true;
            rope.count = 0;
            rope.time = 0;
        });
        
        updateRopeGrid();
    }

    // 停止所有跳繩
    function stopAllRopes() {
        globalTimerActive = false;
        if (globalTimerInterval) {
            clearInterval(globalTimerInterval);
            globalTimerInterval = null;
        }
        
        Object.values(ropeDevices).forEach(rope => {
            rope.isActive = false;
        });
        
        updateRopeGrid();
        showRanking();
    }

    // 開始全局計時器
    function startGlobalTimer() {
        globalTimerActive = true;
        currentCountdownTime = globalCountdownTime;
        
        globalTimerInterval = setInterval(() => {
            currentCountdownTime--;
            updateTimerDisplay();
            
            if (currentCountdownTime <= 0) {
                stopAllRopes();
            }
        }, 1000);
    }

    // 顯示排名
    function showRanking() {
        const rankingList = document.getElementById('rankingList');
        const rankingTimer = document.getElementById('rankingTimer');
        const rankingContent = document.getElementById('rankingContent');
        
        // 更新計時器顯示
        const minutes = Math.floor(globalCountdownTime / 60);
        const seconds = globalCountdownTime % 60;
        rankingTimer.textContent = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
        
        // 生成排名
        const activeRopes = Object.values(ropeDevices).filter(rope => rope.status === '已連接' && rope.selectedStudent);
        activeRopes.sort((a, b) => b.count - a.count);
        
        let rankingHTML = '<div style="text-align: center; margin-bottom: 20px;"><h3>🏆 比賽結果</h3></div>';
        
        if (activeRopes.length === 0) {
            rankingHTML += '<div style="text-align: center; color: #666; padding: 20px;">沒有參賽者</div>';
        } else {
            activeRopes.forEach((rope, index) => {
                const medal = index === 0 ? '🥇' : index === 1 ? '🥈' : index === 2 ? '🥉' : '🏅';
                rankingHTML += 
                    '<div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; margin: 10px 0; background: #f8f9fa; border-radius: 10px; border-left: 4px solid ' + 
                    (index === 0 ? '#ffd700' : index === 1 ? '#c0c0c0' : index === 2 ? '#cd7f32' : '#6c757d') + ';">' +
                        '<div style="display: flex; align-items: center; gap: 10px;">' +
                            '<span style="font-size: 1.5rem;">' + medal + '</span>' +
                            '<div>' +
                                '<div style="font-weight: bold; color: #333;">' + rope.selectedStudentName + '</div>' +
                                '<div style="font-size: 0.9rem; color: #666;">' + rope.id + '</div>' +
                            '</div>' +
                        '</div>' +
                        '<div style="text-align: right;">' +
                            '<div style="font-size: 1.2rem; font-weight: bold; color: #1976d2;">' + rope.count + ' 次</div>' +
                            '<div style="font-size: 0.9rem; color: #666;">' + formatTime(rope.time) + '</div>' +
                        '</div>' +
                    '</div>';
            });
        }
        
        rankingContent.innerHTML = rankingHTML;
        rankingList.style.display = 'block';
    }

    // 顯示成績
    function showScores() {
        if (globalTimerActive) {
            showCustomAlert();
            return;
        }
        
        showRanking();
    }

    // 顯示自定義警告
    function showCustomAlert() {
        document.getElementById('customAlertOverlay').style.display = 'block';
        document.getElementById('customAlert').style.display = 'block';
    }

    // 關閉自定義警告
    function closeCustomAlert() {
        document.getElementById('customAlertOverlay').style.display = 'none';
        document.getElementById('customAlert').style.display = 'none';
    }

    // 重新加載頁面（班級切換）
    function reloadWithNewClass(className) {
        window.location.href = '?class=' + encodeURIComponent(className);
    }

    // 頁面加載完成後初始化
    document.addEventListener('DOMContentLoaded', function() {
        initializeDevices();
        
        // 設置默認班級的學生數據
        Object.values(ropeDevices).forEach(rope => {
            rope.selectedClass = selectedClass;
            if (mockStudents[selectedClass]) {
                rope.studentList = mockStudents[selectedClass];
            }
        });
        
        updateRopeGrid();
    });
    </script>
</body>
</html>
