package test;

import java.util.ArrayList;

public class test {
	// fake data
	public static ArrayList<String> fakedata = new ArrayList<String>();

	public static void fakedata() {
		fakedata.add(
				"841047 Công nghệ phần mềm014DCT11914 01BaBa4123C.E402C.E4021154111541123456789012345123456789012345");
		fakedata.add(
				"841051 Thiết kế giao diện053DCT11953 01SáuTư1922C.A208C.A2081147411474123456789012345123456789012345");
		fakedata.add(
				"841059 Quản trị mạng063DCT11963 01NămNăm9622C.A208C.C1062071420714123456789012345123456789012345");
		fakedata.add("BODA11 Bóng đá 10911 Tư12C.SBDA111152123456789012345");
	}

	// arraylist môn học
	public static ArrayList<MonHoc> mh = new ArrayList<MonHoc>();
	//
	private static ArrayList<String> vec;

	public static void main(String[] args) {
		fakedata();
		for(String data : fakedata) {
			String tenmonhoc = getTenmonHoc(data);
			System.out.println(tenmonhoc);
			data = catbotenmonhoc(data, tenmonhoc);
			data = catboduthua(data);
			getthu(data);
			gettiet(getThutiet(data));
			// nhân đôi môn học , dự theo số lượng của thứ , vd CNPM có 2 thứ ( Ba và Ba ) => nhân đôi
			// tương tự nhân 3 hoặc 1.
			if(vec.size() == 2) {
				MonHoc mh1 = new MonHoc(tenmonhoc, vec.get(0), TietBatDau.get(0), TietKetThuc.get(0));
				MonHoc mh2 = new MonHoc(tenmonhoc, vec.get(1), TietBatDau.get(1), TietKetThuc.get(1));
				mh.add(mh1);
				mh.add(mh2);
			}
			else if(vec.size() == 3) {
				MonHoc mh1 = new MonHoc(tenmonhoc, vec.get(0), TietBatDau.get(0), TietKetThuc.get(0));
				MonHoc mh2 = new MonHoc(tenmonhoc, vec.get(1), TietBatDau.get(1), TietKetThuc.get(1));
				MonHoc mh3 = new MonHoc(tenmonhoc, vec.get(2), TietBatDau.get(2), TietKetThuc.get(2));
				mh.add(mh1);
				mh.add(mh2);
				mh.add(mh3);
			}
			else {
				MonHoc mh1 = new MonHoc(tenmonhoc, vec.get(0), TietBatDau.get(0), TietKetThuc.get(0));
				mh.add(mh1);
			}
		}
		
		// in thử mảng 
		for (MonHoc mh1 : mh) {
			System.out.println(mh1);
		}
	}

	public static String getTenmonHoc(String s) {
		// input ="841047 Công nghệ phần mềm014DCT1191 4
		// 01BaBa4123C.E402C.E4021154111541123456789012345123456789012345DSSV"
		String temp = "";
		s = s.trim();
		for (int i = 7; i < s.length(); i++) {
			if (isNumber(s.charAt(i))) {
				temp = s.substring(7, i);
				break;
			}
		}
		return temp;
		// output = "Công nghệ phần mềm";
	}

	// cắt bỏ tên môn học đi
	public static String catbotenmonhoc(String a, String s) {
		// input : a = 841047 Công nghệ phần mềm014DCT1191 4
		// 01BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
		// b = Công nghệ phần mềm
		if (a.indexOf(s) != -1) {
			String temp = a.substring(0, a.indexOf(s) + s.length());
			a = a.replace(temp, "");
		}
		return a;
		// output = 014DCT1191 4
		// 01BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
	}

	public static String catboduthua(String s) {
		// intput = 014DCT1191 4
		// 01BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
		if (s.lastIndexOf(" ") != -1) {
			int lastIndex = s.lastIndexOf(" ");
			String temp = s.substring(0, lastIndex + 1);
			s = s.replace(temp, "");
		}
		if (s.startsWith("01")) {
			s = s.replace("01", "");
		}
		return s;
		// output= BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
	}

	public static String getThu(String s) {
		String temp = null;
		for (int i = 0; i < s.length(); i++) {
			if (isNumber(s.charAt(i))) {
				temp = s.substring(0, i);
				break;
			}
		}
		return temp;
	}

	public static ArrayList<String> getlistDay(String s) {
		// intput =
		// BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
		ArrayList<String> vec = new ArrayList<String>();
		s = cutNumber(s);
		// s = BaSáuBa
		ArrayList<Integer> list = getListDays(s);
		// list này trả về vị trí của các chữ in hoa trong chuỗi s. Từ đó cắt theo vị
		// trí.
		if (list.size() == 1) {
			String temp = s;
			vec.add(temp);
		} else if (list.size() == 2) {
			String temp = s.substring(0, list.get(1));
			String temp2 = s.substring(list.get(1), s.length());
			vec.add(temp);
			vec.add(temp2);
		} else {
			String temp = s.substring(0, list.get(1));
			String temp2 = s.substring(list.get(1), list.get(2));
			String temp3 = s.substring(list.get(2), s.length());
			vec.add(temp);
			vec.add(temp2);
			vec.add(temp3);
		}
		return vec;
		// trả về 1 arraylist các thứ
	}

	// Lấy vị trí của các từ in hoa trong chuỗi
	public static ArrayList<Integer> getListDays(String s) {
		ArrayList<Integer> list = new ArrayList<Integer>();
		for (int i = 0; i < s.length(); i++) {
			if (Character.isUpperCase(s.charAt(i))) {
				list.add(i);
			}
		}
		return list;
	}

	public static void getthu(String s) {
		vec = new ArrayList<String>();
		vec = getlistDay(s);
		for (String string : vec) {
			System.out.println(string);
		}
	}

	public static String cutNumber(String s) {
		// input = BaSáuBa416238C.E402C.E4021154111541123456789012345123456789012345DSSV
		int i;
		for (i = 0; i < s.length(); i++) {
			if (isNumber(s.charAt(i))) {
				break;
			}
		}
		String temp = s.substring(0, i);
		return temp;
		// output = BaSáuBa
	}

	public static String getThutiet(String s) {
		// input = 416238C.E402C.E4021154111541123456789012345123456789012345DSSV
		int i;
		for (i = 0; i < s.length(); i++) {
			if (isNumber(s.charAt(i))) {
				break;
			}
		}
		String temp = s.substring(0, i);
		s = s.replace(temp, "");
		for (i = 0; i < s.length(); i++) {
			if (!isNumber(s.charAt(i))) {
				break;
			}
		}
		temp = s.substring(0, i);
		return temp;
		// out = 416238
	}

	public static ArrayList<String> TietBatDau;
	public static ArrayList<String> TietKetThuc;

	public static void getdanhsachtiet(String s) {
		
		TietBatDau = new ArrayList<String>();
		TietKetThuc = new ArrayList<String>();
		if (s.length() == 2) {
			String a1 = s.charAt(0) + "";
			String a2 = s.charAt(1) + "";
			TietBatDau.add(a1);
			TietKetThuc.add(a2);
		}
		if (s.length() == 4) {
			String a1 = s.charAt(0) + "";
			String a2 = s.charAt(1) + "";
			String a3 = s.charAt(2) + "";
			String a4 = s.charAt(3) + "";
			TietBatDau.add(a1);
			TietBatDau.add(a2);
			TietKetThuc.add(a3);
			TietKetThuc.add(a4);
		}
		if (s.length() == 6) {
			TietBatDau.add(s.charAt(0) + "");
			TietBatDau.add(s.charAt(1) + "");
			TietBatDau.add(s.charAt(2) + "");
			TietKetThuc.add(s.charAt(3) + "");
			TietKetThuc.add(s.charAt(4) + "");
			TietKetThuc.add(s.charAt(5) + "");
		}

	}

	public static void gettiet(String s) {
		getdanhsachtiet(s);
		if (TietBatDau.size() > 0) {
			for (int i = 0; i < TietBatDau.size(); i++) {
				System.out.println("Tiết Bắt Đầu :" + TietBatDau.get(i));
				System.out.println("Tiết Kết Thúc :" + TietKetThuc.get(i));
			}
		}
	}
	
	public static void clear() {
		vec= null;
		TietBatDau = null;
		TietKetThuc = null;
	}

	public static boolean isNumber(char s) {
		try {
			Integer.parseInt(s + "");
			return true;
		} catch (Exception e) {
			return false;
		}
	}

}
