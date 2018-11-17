import request from '@/utils/request'

export const querySick = data => request.post('querySick.php', data);  //查询病例接口

export const selectHospital = data => request.post("selectHospital.php", data); //选择医院

export const selectDoctor = data => request.post("selectDoctor.php", data); //在选择医院之后选择医生

export const selectTime = data => request.post("selectTime.php", data);
//在选择医生之后选择病人要预约的时间段。

export const checkValidTime = data => request.post("checkValidTime.php", data);
//检查该时间段医生是否请假。

export const appointment = data => request.post("appointment.php", data); //预约医生。

export const checkAppointment = data => request.post("checkAppointment.php", data);
//确认已被预约的时间段。