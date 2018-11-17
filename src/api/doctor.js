import request from '@/utils/request';

export const medicine = data => request.post('medicine.php', data); //药品接口

export const checkCustom = data => request.post('checkCustom.php', data); //检测病人信息是否正确

export const cureConclusion = data => request.post('cureConclusion.php', data); //诊断完以后上传

export const queryMedical = data => request.post('queryMedical.php', data);  //查询就诊记录

export const leave = data => request.post("leave.php", data); //请假接口

export const checkIfLeave = data => request.post("checkIfleave.php", data) //检查医生是否请假决定页面显示。

export const overAdvance = data => request.post("overAdvance.php", data) //提前结束请假状态

export const extendTime = data => request.post("extendTime.php", data) //延长时间