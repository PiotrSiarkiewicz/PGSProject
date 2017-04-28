using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;


namespace ConsoleApplication1
{
    class Program
    {
        public static int _width;
        public static int _height;
        private static void FileWrite()
        {
            FileStream fileStream = new FileStream("wymiaryOkna.txt", FileMode.Create,FileAccess.Write);

            StreamWriter streamWriter = new StreamWriter(fileStream);
            streamWriter.WriteLine("30");
            streamWriter.WriteLine("60");
            streamWriter.Close();
        }

        private static void FileRead()
        {

            FileStream fileStream = new FileStream("wymiaryOkna.txt", FileMode.Open, FileAccess.Read);
            StreamReader streamReader = new StreamReader(fileStream);
            _height = int.Parse(streamReader.ReadLine());
            _width = int.Parse(streamReader.ReadLine());
            
            
        }
        static void Main(string[] args)
        {
            FileWrite();
            FileRead();
            World world = new World(_height,_width);
            
            world.LastManStanding();
            
            
            Console.ReadKey();

        }
    }
}
