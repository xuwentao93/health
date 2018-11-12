import request from '@/utils/request';

export const medicine = data => request.post('medicine.php', data); //药品接口

export const checkCustom = data => request.post('checkCustom.php', data); //检测病人信息是否正确

export const cureConclusion = data => request.post('cureConclusion.php', data); //诊断完以后上传

export const queryMedical = data => request.post('queryMedical.php', data);  //查询就诊记录