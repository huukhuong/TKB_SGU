package test;

public class MonHoc {
	private String ten ;
	private String thu;
	private String tietbd;
	private String sotiet;
	public String getTen() {
		return ten;
	}
	public void setTen(String ten) {
		this.ten = ten;
	}
	public String getThu() {
		return thu;
	}
	public void setThu(String thu) {
		this.thu = thu;
	}
	public String getTietbd() {
		return tietbd;
	}
	public void setTietbd(String tietbd) {
		this.tietbd = tietbd;
	}
	public String getSotiet() {
		return sotiet;
	}
	public void setSotiet(String sotiet) {
		this.sotiet = sotiet;
	}
	public MonHoc(String ten, String thu, String tietbd, String sotiet) {
		super();
		this.ten = ten;
		this.thu = thu;
		this.tietbd = tietbd;
		this.sotiet = sotiet;
	}
	public MonHoc() {
		super();
		// TODO Auto-generated constructor stub
	}
	@Override
	public String toString() {
		return "MonHoc [ten=" + ten + ", thu=" + thu + ", tietbd=" + tietbd + ", sotiet=" + sotiet + "]";
	}
	
}
